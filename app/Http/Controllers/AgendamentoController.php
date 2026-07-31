<?php
namespace App\Http\Controllers;
use App\Models\Agendamento;
use App\Models\Barbeiro;
use App\Models\Servico;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AgendamentoController extends Controller
{
    public function index()
    {
        $barbeiros = Barbeiro::where('ativo', true)->get();
        $servicos = Servico::where('ativo', true)->get();
        return view('agendamento', compact('barbeiros', 'servicos'));
    }
    public function horariosDisponiveis(Request $request)
    {
        $barbeiro = Barbeiro::findOrFail($request->barbeiro_id);
        $data = Carbon::parse($request->data);
        $horaInicio = Carbon::parse($data->format('Y-m-d') . ' ' . $barbeiro->hora_inicio);
        $horaFim = Carbon::parse($data->format('Y-m-d') . ' ' . $barbeiro->hora_fim);
        $horarios = [];
        $atual = $horaInicio->copy();
        while ($atual->copy()->addHour()->lte($horaFim)) {
            $ocupado = Agendamento::where('barbeiro_id', $barbeiro->id)
                ->where('data', $data->format('Y-m-d'))
                ->where('horario', $atual->format('H:i'))
                ->whereIn('status', ['pendente', 'confirmado'])
                ->exists();
            $horarios[] = [
                'horario' => $atual->format('H:i'),
                'disponivel' => !$ocupado,
            ];
            $atual->addHour();
        }
        return response()->json($horarios);
    }
    public function store(Request $request)
    {
        $request->validate([
            'cliente_nome' => 'required|string|max:255',
            'cliente_telefone' => 'required|string|max:20',
            'barbeiro_id' => 'required|exists:barbeiros,id',
            'servico_id' => 'required|exists:servicos,id',
            'data' => 'required|date|after_or_equal:today',
            'horario' => 'required',
        ]);
        $barbeiro = Barbeiro::find($request->barbeiro_id);
        $servico = Servico::find($request->servico_id);
        $agendamento = Agendamento::create([
            'cliente_nome' => $request->cliente_nome,
            'cliente_telefone' => $request->cliente_telefone,
            'barbeiro_id' => $request->barbeiro_id,
            'servico_id' => $request->servico_id,
            'data' => $request->data,
            'horario' => $request->horario,
            'status' => 'confirmado',
        ]);
        try {
            $host = $request->getHost();
            $subdominio = str_replace('.barberpro.tech', '', $host);
            $tenantData = \App\Models\Tenant::on('sqlite')->where('subdominio', $subdominio)->first();
            if (!$tenantData) { $tenantData = \DB::connection('sqlite')->table('tenants')->where('subdominio', $subdominio)->first(); }
            $endereco = $tenantData->endereco ?? '';
            \Illuminate\Support\Facades\Log::info('[ENDERECO] ' . $endereco);
            $whatsapp = new WhatsAppService();
            $dataFormatada = Carbon::parse($request->data)->format('d/m/Y');
            $whatsapp->confirmarAgendamento(
                $request->cliente_telefone,
                $request->cliente_nome,
                $barbeiro->nome,
                $servico->nome,
                $dataFormatada,
                $request->horario,
                $endereco
            );
            $whatsapp->notificarBarbearia(
                $request->cliente_nome,
                $request->cliente_telefone,
                $barbeiro->nome,
                $servico->nome,
                $dataFormatada,
                $request->horario
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('[WhatsApp] ' . $e->getMessage());
        }
        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Agendamento realizado com sucesso!',
            'agendamento_id' => $agendamento->id,
        ]);
    }
}
