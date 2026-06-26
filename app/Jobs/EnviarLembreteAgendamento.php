<?php

namespace App\Jobs;

use App\Models\Agendamento;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnviarLembreteAgendamento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
{
    $agora = Carbon::now();
    $inicio = $agora->copy()->addMinutes(18);
    $fim = $agora->copy()->addMinutes(22);

    $agendamentos = Agendamento::with(['barbeiro', 'servico'])
        ->whereIn('status', ['pendente', 'confirmado'])
        ->where('lembrete_enviado', false)
        ->whereDate('data', $agora->format('Y-m-d'))
        ->whereTime('horario', '>=', $inicio->format('H:i'))
        ->whereTime('horario', '<=', $fim->format('H:i'))
        ->get();

    $whatsapp = new WhatsAppService();

    foreach ($agendamentos as $agendamento) {
        $enviado = $whatsapp->enviarLembrete(
            $agendamento->cliente_telefone,
            $agendamento->cliente_nome,
            $agendamento->barbeiro->nome,
            $agendamento->servico->nome,
            $agendamento->horario
        );

        if ($enviado) {
            $agendamento->update(['lembrete_enviado' => true]);
            Log::info("[Lembrete] Enviado para {$agendamento->cliente_nome}");
        }
    }
}
}
