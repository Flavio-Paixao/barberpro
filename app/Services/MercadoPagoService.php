<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MercadoPagoService
{
    private string $accessToken;
    private string $baseUrl = 'https://api.mercadopago.com';

    public function __construct()
    {
        $this->accessToken = config('services.mercadopago.access_token');
    }

    public function criarPagamento(Tenant $tenant): ?array
    {
        $response = Http::withToken($this->accessToken)
            ->post("{$this->baseUrl}/checkout/preferences", [
                'items' => [
                    [
                        'title' => "Mensalidade BarberPro — {$tenant->nome}",
                        'quantity' => 1,
                        'unit_price' => (float) $tenant->mensalidade,
                        'currency_id' => 'BRL',
                    ],
                ],
                'payer' => [
                    'email' => $tenant->email,
                ],
                'back_urls' => [
                    'success' => "https://{$tenant->subdominio}.barberpro.tech/painel?pagamento=sucesso",
                    'failure' => "https://{$tenant->subdominio}.barberpro.tech/painel?pagamento=erro",
                    'pending' => "https://{$tenant->subdominio}.barberpro.tech/painel?pagamento=pendente",
                ],
                'auto_return' => 'approved',
                'notification_url' => 'https://app.barberpro.tech/webhook/mercadopago',
                'external_reference' => (string) $tenant->id,
            ]);

        if ($response->successful()) {
            $data = $response->json();

            $tenant->update(['mp_preference_id' => $data['id']]);

            Log::info("[MercadoPago] Preferência criada para tenant {$tenant->id}: {$data['id']}");

            return [
                'id' => $data['id'],
                'link_pagamento' => $data['init_point'],
            ];
        }

        Log::error("[MercadoPago] Erro ao criar pagamento: " . $response->body());
        return null;
    }

    public function consultarPagamento(string $paymentId): ?array
    {
        $response = Http::withToken($this->accessToken)
            ->get("{$this->baseUrl}/v1/payments/{$paymentId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error("[MercadoPago] Erro ao consultar pagamento {$paymentId}: " . $response->body());
        return null;
    }

    public function processarWebhook(array $data): void
    {
        if (($data['type'] ?? '') !== 'payment') {
            return;
        }

        $paymentId = $data['data']['id'] ?? null;
        if (!$paymentId) {
            return;
        }

        $pagamento = $this->consultarPagamento($paymentId);
        if (!$pagamento) {
            return;
        }

        $tenantId = $pagamento['external_reference'] ?? null;
        if (!$tenantId) {
            return;
        }

        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            return;
        }

        if ($pagamento['status'] === 'approved') {
            $tenant->update([
                'status' => 'ativo',
                'pagamento_expira_em' => now()->addDays(30),
                'mp_payment_id' => $paymentId,
            ]);
            Log::info("[MercadoPago] Pagamento aprovado para tenant {$tenant->id} — ativado por 30 dias");
        } else {
            Log::info("[MercadoPago] Pagamento {$paymentId} com status: {$pagamento['status']}");
        }
    }
}
