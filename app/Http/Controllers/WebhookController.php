<?php
namespace App\Http\Controllers;
use App\Models\Tenant;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::emergency('[Webhook] Recebido: ' . json_encode($request->all()));
        $phone = $request->input('phone');
        $message = strtoupper(trim($request->input('text.message') ?? $request->input('message') ?? ''));
        Log::emergency('[Webhook] Phone: ' . $phone . ' | Message: ' . $message);
        if (!$phone || !$message) {
            return response()->json(['ok' => false, 'reason' => 'no phone or message']);
        }
        $telefone = preg_replace('/\D/', '', $phone);
        if (!str_starts_with($telefone, '55')) {
            $telefone = '55' . $telefone;
        }
        $tenants = Tenant::where('status', 'ativo')->orWhere('status', 'trial')->get();
        Log::emergency('[Webhook] Tenants: ' . $tenants->count());
        $whatsapp = new WhatsAppService();
        foreach ($tenants as $tenant) {
            try {
                Config::set('database.connections.tenant_webhook', [
                    'driver' => 'sqlite',
                    'database' => $tenant->getDatabasePath(),
                    'prefix' => '',
                    'foreign_key_constraints' => true,
                ]);
                DB::purge('tenant_webhook');
                $ultimos8 = substr($telefone, -8);
                $hoje = Carbon::today()->format('Y-m-d');
                Log::emergency('[Webhook] Buscando no tenant: ' . $tenant->subdominio . ' | ultimos8: ' . $ultimos8 . ' | hoje: ' . $hoje);
                $agendamento = DB::connection('tenant_webhook')
                    ->table('agendamentos')
                    ->join('barbeiros', 'agendamentos.barbeiro_id', '=', 'barbeiros.id')
                    ->join('servicos', 'agendamentos.servico_id', '=', 'servicos.id')
                    ->whereIn('agendamentos.status', ['pendente', 'confirmado'])
                    ->where('agendamentos.lembrete_enviado', true)
                    ->where('agendamentos.data', '>=', $hoje)
                    ->whereRaw("REPLACE(REPLACE(REPLACE(agendamentos.cliente_telefone, ' ', ''), '-', ''), '(', '') LIKE ?", ["%{$ultimos8}%"])
                    ->orderBy('agendamentos.data')
                    ->orderBy('agendamentos.horario')
                    ->select(
                        'agendamentos.id',
                        'agendamentos.cliente_telefone',
                        'agendamentos.horario',
                        'barbeiros.nome as barbeiro_nome',
                        'servicos.nome as servico_nome'
                    )
                    ->first();
                Log::emergency('[Webhook] Agendamento encontrado: ' . ($agendamento ? $agendamento->id : 'nenhum'));
                if (!$agendamento) continue;
                if ($message === 'CONFIRMAR' || $message === '1') {
                    DB::connection('tenant_webhook')
                        ->table('agendamentos')
                        ->where('id', $agendamento->id)
                        ->update(['status' => 'confirmado']);
                    $whatsapp->enviarMensagem(
                        $agendamento->cliente_telefone,
                        "✅ Agendamento *confirmado*!\n\nTe esperamos às *{$agendamento->horario}* com *{$agendamento->barbeiro_nome}*.\n\nAté logo! 😊"
                    );
                    Log::emergency("[Webhook] Confirmado: #{$agendamento->id}");
                } elseif ($message === 'CANCELAR' || $message === '2') {
                    DB::connection('tenant_webhook')
                        ->table('agendamentos')
                        ->where('id', $agendamento->id)
                        ->update(['status' => 'cancelado']);
                    $whatsapp->enviarMensagem(
                        $agendamento->cliente_telefone,
                        "❌ Agendamento *cancelado*.\n\nTudo bem! Quando quiser agendar novamente é só acessar nosso link. 😊"
                    );
                    $telefoneTenant = Tenant::where('id', $tenant->id)->value('telefone');
                    if ($telefoneTenant) {
                        $whatsapp->enviarMensagem(
                            $telefoneTenant,
                            "⚠️ Agendamento cancelado!\n\nCliente cancelou o horário das *{$agendamento->horario}* - Serviço: {$agendamento->servico_nome}"
                        );
                    }
                    Log::emergency("[Webhook] Cancelado: #{$agendamento->id}");
                }
                return response()->json(['ok' => true]);
            } catch (\Throwable $e) {
                Log::emergency("[Webhook] Erro: " . $e->getMessage());
            }
        }
        return response()->json(['ok' => false]);
    }
}
