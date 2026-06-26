<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('[Webhook] Recebido: ' . json_encode($request->all()));

        // Z-API envia mensagens recebidas neste formato
        $phone = $request->input('phone');
        $message = trim($request->input('text.message') ?? $request->input('message') ?? '');

        if (!$phone || !$message) {
            return response()->json(['ok' => false]);
        }

        // Limpa o número
        $telefone = preg_replace('/\D/', '', $phone);
        if (!str_starts_with($telefone, '55')) {
            $telefone = '55' . $telefone;
        }

        // Busca agendamento pendente mais próximo deste cliente
        $agendamento = Agendamento::with(['barbeiro', 'servico'])
            ->whereIn('status', ['pendente', 'confirmado'])
            ->where('lembrete_enviado', true)
            ->whereRaw("REPLACE(REPLACE(REPLACE(cliente_telefone, ' ', ''), '-', ''), '(', '') LIKE ?", ['%' . substr($telefone, -8) . '%'])
            ->where('data', '>=', Carbon::today())
            ->orderBy('data')
            ->orderBy('horario')
            ->first();

        if (!$agendamento) {
            Log::info("[Webhook] Nenhum agendamento encontrado para {$telefone}");
            return response()->json(['ok' => false]);
        }

        $whatsapp = new WhatsAppService();

        if ($message === '1') {
            $agendamento->update(['status' => 'confirmado']);

            $whatsapp->enviarMensagem(
                $agendamento->cliente_telefone,
                "✅ Agendamento *confirmado*!\n\n" .
                "Te esperamos às *{$agendamento->horario}* com *{$agendamento->barbeiro->nome}*.\n\n" .
                "Até logo! 💈"
            );

            Log::info("[Webhook] Confirmado: agendamento #{$agendamento->id}");

        } elseif ($message === '2') {
            $agendamento->update(['status' => 'cancelado']);

            $whatsapp->enviarMensagem(
                $agendamento->cliente_telefone,
                "❌ Agendamento *cancelado*.\n\n" .
                "Tudo bem! Quando quiser agendar novamente é só acessar nosso link. 😊"
            );

            Log::info("[Webhook] Cancelado: agendamento #{$agendamento->id}");
        }

        return response()->json(['ok' => true]);
    }
}
