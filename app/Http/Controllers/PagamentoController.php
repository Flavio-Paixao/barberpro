<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PagamentoController extends Controller
{
    public function gerarLink(Tenant $tenant)
    {
        $service = new MercadoPagoService();
        $resultado = $service->criarPagamento($tenant);

        if ($resultado) {
            return back()->with('success', 'Link de pagamento gerado! Veja abaixo.')
                ->with('link_pagamento', $resultado['link_pagamento']);
        }

        return back()->withErrors(['erro' => 'Não foi possível gerar o link de pagamento.']);
    }

    public function toggleCobranca(Tenant $tenant)
    {
        $tenant->update(['cobranca_automatica' => !$tenant->cobranca_automatica]);
        return back()->with('success', 'Modalidade de cobrança atualizada!');
    }

    public function webhook(Request $request)
    {
        Log::info('[MercadoPago Webhook] Recebido: ' . json_encode($request->all()));

        $service = new MercadoPagoService();
        $service->processarWebhook($request->all());

        return response()->json(['status' => 'ok']);
    }
}
