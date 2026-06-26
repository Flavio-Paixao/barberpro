<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SuperAdminTenantController extends Controller
{
    private function conectarTenant(Tenant $tenant): void
    {
        Config::set('database.connections.tenant_view', [
            'driver' => 'sqlite',
            'database' => $tenant->getDatabasePath(),
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
        DB::purge('tenant_view');
    }

    public function show(Tenant $tenant)
    {
        $this->conectarTenant($tenant);

        $barbeiros = DB::connection('tenant_view')->table('barbeiros')->orderBy('nome')->get();
        $servicos = DB::connection('tenant_view')->table('servicos')->orderBy('nome')->get();

        $agendamentos = DB::connection('tenant_view')->table('agendamentos')
            ->orderByDesc('data')
            ->orderByDesc('horario')
            ->limit(50)
            ->get();

        // Faturamento últimos 6 meses
        $faturamentoMensal = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $inicio = $mes->copy()->startOfMonth()->format('Y-m-d');
            $fim = $mes->copy()->endOfMonth()->format('Y-m-d');

            $ags = DB::connection('tenant_view')->table('agendamentos')
                ->whereBetween('data', [$inicio, $fim])
                ->whereIn('status', ['confirmado', 'pendente'])
                ->get();

            $total = 0;
            foreach ($ags as $ag) {
                $servico = DB::connection('tenant_view')->table('servicos')->find($ag->servico_id);
                $total += $servico->preco ?? 0;
            }

            $faturamentoMensal[] = ['mes' => $mes->format('M/y'), 'total' => $total];
        }

        $faturamentoTotal = array_sum(array_column($faturamentoMensal, 'total'));
        $totalAgendamentos = DB::connection('tenant_view')->table('agendamentos')->count();

        return view('superadmin.tenant-detail', compact(
            'tenant', 'barbeiros', 'servicos', 'agendamentos',
            'faturamentoMensal', 'faturamentoTotal', 'totalAgendamentos'
        ));
    }

    public function storeBarbeiro(Request $request, Tenant $tenant)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade' => 'nullable|string|max:255',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
        ]);

        $this->conectarTenant($tenant);

        DB::connection('tenant_view')->table('barbeiros')->insert([
            'nome' => $request->nome,
            'especialidade' => $request->especialidade,
            'ativo' => true,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Barbeiro adicionado com sucesso!');
    }

    public function deleteBarbeiro(Tenant $tenant, $barbeiroId)
    {
        $this->conectarTenant($tenant);
        DB::connection('tenant_view')->table('barbeiros')->where('id', $barbeiroId)->delete();
        return back()->with('success', 'Barbeiro removido!');
    }

    public function toggleBarbeiro(Tenant $tenant, $barbeiroId)
    {
        $this->conectarTenant($tenant);
        $barbeiro = DB::connection('tenant_view')->table('barbeiros')->where('id', $barbeiroId)->first();
        DB::connection('tenant_view')->table('barbeiros')->where('id', $barbeiroId)->update(['ativo' => !$barbeiro->ativo]);
        return back()->with('success', 'Status do barbeiro atualizado!');
    }

    public function storeServico(Request $request, Tenant $tenant)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'duracao_minutos' => 'required|integer|min:15',
        ]);

        $this->conectarTenant($tenant);

        DB::connection('tenant_view')->table('servicos')->insert([
            'nome' => $request->nome,
            'preco' => $request->preco,
            'duracao_minutos' => $request->duracao_minutos,
            'ativo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Serviço adicionado com sucesso!');
    }

    public function deleteServico(Tenant $tenant, $servicoId)
    {
        $this->conectarTenant($tenant);
        DB::connection('tenant_view')->table('servicos')->where('id', $servicoId)->delete();
        return back()->with('success', 'Serviço removido!');
    }

    public function toggleServico(Tenant $tenant, $servicoId)
    {
        $this->conectarTenant($tenant);
        $servico = DB::connection('tenant_view')->table('servicos')->where('id', $servicoId)->first();
        DB::connection('tenant_view')->table('servicos')->where('id', $servicoId)->update(['ativo' => !$servico->ativo]);
        return back()->with('success', 'Status do serviço atualizado!');
    }

    public function updateNotas(Request $request, Tenant $tenant)
    {
        $tenant->update(['notas_internas' => $request->notas_internas]);
        return back()->with('success', 'Notas salvas!');
    }

    public function updateMensalidade(Request $request, Tenant $tenant)
    {
        $request->validate(['mensalidade' => 'required|numeric|min:0']);
        $tenant->update(['mensalidade' => $request->mensalidade]);
        return back()->with('success', 'Mensalidade atualizada!');
    }

    public function renovarTrial(Request $request, Tenant $tenant)
    {
        $dias = $request->input('dias', 30);
        $tenant->update([
            'status' => 'trial',
            'trial_expira_em' => now()->addDays((int) $dias),
        ]);

        return back()->with('success', "Trial renovado por mais {$dias} dias!");
    }

    public function updateDadosCadastrais(Request $request, Tenant $tenant)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'responsavel' => 'nullable|string|max:255',
            'email' => 'required|email',
            'telefone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'horario_abertura' => 'nullable',
            'horario_fechamento' => 'nullable',
        ]);

        $tenant->update($request->only([
            'nome', 'responsavel', 'email', 'telefone', 'whatsapp',
            'endereco', 'horario_abertura', 'horario_fechamento',
        ]));

        return back()->with('success', 'Dados cadastrais atualizados!');
    }
}

