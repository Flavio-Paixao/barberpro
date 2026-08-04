<?php
namespace App\Jobs;
use App\Models\Tenant;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class EnviarLembreteAgendamento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function handle(): void
    {
        $agora = Carbon::now();
        $inicio = $agora->copy()->addMinutes(18)->format('H:i');
        $fim = $agora->copy()->addMinutes(22)->format('H:i');
        $hoje = $agora->format('Y-m-d');
        $tenants = Tenant::where('status', 'ativo')->orWhere('status', 'trial')->get();
        $whatsapp = new WhatsAppService();
        foreach ($tenants as $tenant) {
            try {
                Config::set('database.connections.tenant_lembrete', [
                    'driver' => 'sqlite',
                    'database' => $tenant->getDatabasePath(),
                    'prefix' => '',
                    'foreign_key_constraints' => true,
                ]);
                DB::purge('tenant_lembrete');
                $agendamentos = DB::connection('tenant_lembrete')
                    ->table('agendamentos')
                    ->join('barbeiros', 'agendamentos.barbeiro_id', '=', 'barbeiros.id')
                    ->join('servicos', 'agendamentos.servico_id', '=', 'servicos.id')
                    ->whereIn('agendamentos.status', ['pendente', 'confirmado'])
                    ->where('agendamentos.lembrete_enviado', false)
                    ->where('agendamentos.data', $hoje)
                    ->where('agendamentos.horario', '>=', $inicio)
                    ->where('agendamentos.horario', '<=', $fim)
                    ->select(
                        'agendamentos.id',
                        'agendamentos.cliente_nome',
                        'agendamentos.cliente_telefone',
                        'agendamentos.horario',
                        'barbeiros.nome as barbeiro_nome',
                        'servicos.nome as servico_nome'
                    )
                    ->get();
                foreach ($agendamentos as $ag) {
                    $enviado = $whatsapp->enviarLembrete(
                        $ag->cliente_telefone,
                        $ag->cliente_nome,
                        $ag->barbeiro_nome,
                        $ag->servico_nome,
                        $ag->horario
                    );
                    if ($enviado) {
                        DB::connection('tenant_lembrete')
                            ->table('agendamentos')
                            ->where('id', $ag->id)
                            ->update(['lembrete_enviado' => true]);
                        Log::info("[Lembrete] Enviado para {$ag->cliente_nome} - Tenant: {$tenant->subdominio}");
                    }
                }
            } catch (\Throwable $e) {
                Log::error("[Lembrete] Erro no tenant {$tenant->subdominio}: " . $e->getMessage());
            }
        }
    }
}
