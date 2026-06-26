<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Services\MercadoPagoService;
use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificarVencimentos implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $whatsapp = new WhatsAppService();

        $tenants = Tenant::whereIn('status', ['trial', 'ativo'])->get();

        foreach ($tenants as $tenant) {
            $dataVencimento = $tenant->status === 'trial'
                ? $tenant->trial_expira_em
                : $tenant->pagamento_expira_em;

            if (!$dataVencimento) {
                continue;
            }

            $diasRestantes = now()->startOfDay()->diffInDays($dataVencimento->startOfDay(), false);

            if (!in_array($diasRestantes, [3, 1])) {
                continue;
            }

            if ($tenant->whatsapp) {
                $whatsapp->enviarAvisoVencimento(
                    $tenant->whatsapp,
                    $tenant->nome,
                    $diasRestantes,
                    (float) $tenant->mensalidade
                );
                Log::info("[Vencimento] Aviso WhatsApp enviado para tenant {$tenant->id} ({$diasRestantes} dias)");
            }

            if ($tenant->email) {
                try {
                    Mail::to($tenant->email)->send(new \App\Mail\AvisoVencimentoMail($tenant, $diasRestantes));
                    Log::info("[Vencimento] Aviso e-mail enviado para tenant {$tenant->id} ({$diasRestantes} dias)");
                } catch (\Exception $e) {
                    Log::error("[Vencimento] Erro ao enviar e-mail para tenant {$tenant->id}: " . $e->getMessage());
                }
            }

            if ($tenant->cobranca_automatica) {
                $mpService = new MercadoPagoService();
                $resultado = $mpService->criarPagamento($tenant);

                if ($resultado && $tenant->whatsapp) {
                    $whatsapp->enviarLinkPagamento(
                        $tenant->whatsapp,
                        $tenant->nome,
                        $resultado['link_pagamento'],
                        (float) $tenant->mensalidade
                    );
                    Log::info("[Vencimento] Link de pagamento automático enviado para tenant {$tenant->id}");
                }
            }
        }
    }
}
