<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $instanceId;
    private string $token;
    private string $baseUrl;

    public function __construct()
    {
        $this->instanceId = config('services.zapi.instance_id');
        $this->token = config('services.zapi.token');
        $this->baseUrl = config('services.zapi.base_url');
    }

    public function enviarMensagem(string $telefone, string $mensagem): bool
{
    try {
        $numero = $this->formatarTelefone($telefone);

        $response = Http::withoutVerifying()
    ->withHeaders([
        'Client-Token' => config('services.zapi.client_token'),
    ])->post("{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/send-text", [
        'phone' => $numero,
        'message' => $mensagem,
    ]);

        if ($response->successful()) {
            Log::info("[WhatsApp] Mensagem enviada para {$numero}");
            return true;
        }

        Log::error("[WhatsApp] Erro ao enviar para {$numero}: " . $response->body());
        return false;

    } catch (\Exception $e) {
        Log::error("[WhatsApp] Exception: " . $e->getMessage());
        return false;
    }
}

    public function confirmarAgendamento(string $telefone, string $clienteNome, string $barbeiro, string $servico, string $data, string $horario, string $endereco = ''): bool
    {
        $mensagem = "Olá {$clienteNome}! 🎉\n\n";
        $mensagem .= "Seu agendamento foi confirmado!\n\n";
        $mensagem .= "✂️ Serviço: {$servico}\n";
        $mensagem .= "👨 Barbeiro: {$barbeiro}\n";
        $mensagem .= "📅 Data: {$data}\n";
        $mensagem .= "⏰ Horário: {$horario}\n";
        $mensagem .= "📍 Local: " . ($endereco ?: env('BARBEARIA_ENDERECO', 'A confirmar')) . "\n\n";
        $mensagem .= "Te esperamos! 💈";

        return $this->enviarMensagem($telefone, $mensagem);
    }

    public function notificarBarbearia(string $clienteNome, string $clienteTelefone, string $barbeiro, string $servico, string $data, string $horario, string $telefoneBarbearia = ''): bool
    {
        $telefoneBarbearia = $telefoneBarbearia ?: env('BARBEARIA_TELEFONE');

        $mensagem = "🔔 Novo agendamento!\n\n";
        $mensagem .= "👤 Cliente: {$clienteNome}\n";
        $mensagem .= "📱 WhatsApp: {$clienteTelefone}\n";
        $mensagem .= "✂️ Serviço: {$servico}\n";
        $mensagem .= "👨 Barbeiro: {$barbeiro}\n";
        $mensagem .= "📅 Data: {$data}\n";
        $mensagem .= "⏰ Horário: {$horario}";

        return $this->enviarMensagem($telefoneBarbearia, $mensagem);
    }

    public function enviarLembrete(string $telefone, string $clienteNome, string $barbeiro, string $servico, string $horario): bool
    {
        $mensagem = "Olá {$clienteNome}! ⏰\n\n";
        $mensagem .= "Seu horário é em 20 minutos!\n\n";
        $mensagem .= "✂️ {$servico} com {$barbeiro} às {$horario}\n\n";
        $mensagem .= "Responda:\n";
        $mensagem .= "1️⃣ CONFIRMAR\n";
        $mensagem .= "2️⃣ CANCELAR";

        return $this->enviarMensagem($telefone, $mensagem);
    }

    public function enviarLinkPagamento(string $telefone, string $nomeBarbearia, string $link, float $valor): bool
{
    $mensagem = "Olá {$nomeBarbearia}! 💈\n\n";
    $mensagem .= "Segue o link para pagamento da sua mensalidade do BarberPro:\n\n";
    $mensagem .= "💰 Valor: R$ " . number_format($valor, 2, ',', '.') . "\n\n";
    $mensagem .= "🔗 Pague aqui: {$link}\n\n";
    $mensagem .= "Após o pagamento, seu acesso é renovado automaticamente!";
    return $this->enviarMensagem($telefone, $mensagem);
}

public function enviarAvisoVencimento(string $telefone, string $nomeBarbearia, int $diasRestantes, float $valor, ?string $linkPagamento = null): bool
{
    $mensagem = "Olá {$nomeBarbearia}! ⏰\n\n";
    if ($diasRestantes === 1) {
        $mensagem .= "Sua mensalidade do BarberPro vence AMANHÃ!\n\n";
    } else {
        $mensagem .= "Sua mensalidade do BarberPro vence em {$diasRestantes} dias!\n\n";
    }
    $mensagem .= "💰 Valor: R$ " . number_format($valor, 2, ',', '.') . "\n\n";

    if ($linkPagamento) {
        $mensagem .= "🔗 Pague aqui (PIX ou cartão): {$linkPagamento}\n\n";
        $mensagem .= "Após o pagamento, seu acesso é renovado automaticamente!";
    } else {
        $mensagem .= "Entre em contato para renovar e continuar usando o sistema sem interrupções.";
    }

    return $this->enviarMensagem($telefone, $mensagem);
}


    private function formatarTelefone(string $telefone): string
    {
        $numero = preg_replace('/\D/', '', $telefone);
        if (!str_starts_with($numero, '55')) {
            $numero = '55' . $numero;
        }
        return $numero;
    }
}
