<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WebhookController;

// Webhook Mercado Pago
Route::post('/webhook/mercadopago', [\App\Http\Controllers\PagamentoController::class, 'webhook'])->name('webhook.mercadopago');

// Super Admin Login
Route::get('/superadmin/login', [\App\Http\Controllers\SuperAdminLoginController::class, 'show'])->name('superadmin.login');
Route::post('/superadmin/login', [\App\Http\Controllers\SuperAdminLoginController::class, 'store']);

// Login
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Público
Route::get('/', [AgendamentoController::class, 'index'])->name('home');
Route::get('/horarios-disponiveis', [AgendamentoController::class, 'horariosDisponiveis'])->name('horarios.disponiveis');
Route::post('/agendar', [AgendamentoController::class, 'store'])->name('agendamento.store');
Route::get('/termos', fn() => view('termos'))->name('termos');
Route::get('/privacidade', fn() => view('privacidade'))->name('privacidade');

// Webhook Z-API
Route::post('/webhook/zapi', [WebhookController::class, 'handle'])->name('webhook.zapi');

// Painel customizado
Route::middleware('auth')->group(function () {
    Route::get('/painel', [PainelController::class, 'index'])->name('painel');
    Route::get('/painel/agendamentos', [PainelController::class, 'agendamentos'])->name('painel.agendamentos');
    Route::get('/painel/financeiro', [PainelController::class, 'financeiro'])->name('painel.financeiro');
    Route::get('/painel/barbeiros', [PainelController::class, 'barbeiros'])->name('painel.barbeiros');
    Route::get('/painel/servicos', [PainelController::class, 'servicos'])->name('painel.servicos');
    Route::post('/painel/agendamento/{id}/status', [PainelController::class, 'atualizarStatus'])->name('painel.status');

    // Super Admin (protegido)
    Route::get('/superadmin', [\App\Http\Controllers\SuperAdminController::class, 'index'])->name('superadmin');
    Route::post('/superadmin/tenants/{tenant}/toggle', [\App\Http\Controllers\SuperAdminController::class, 'toggleStatus'])->name('superadmin.toggle');

    // Super Admin - Tenant Detail
    Route::get('/superadmin/tenants/{tenant}', [\App\Http\Controllers\SuperAdminTenantController::class, 'show'])->name('superadmin.tenant.show');
    Route::post('/superadmin/tenants/{tenant}/barbeiros', [\App\Http\Controllers\SuperAdminTenantController::class, 'storeBarbeiro'])->name('superadmin.barbeiro.store');
    Route::delete('/superadmin/tenants/{tenant}/barbeiros/{barbeiroId}', [\App\Http\Controllers\SuperAdminTenantController::class, 'deleteBarbeiro'])->name('superadmin.barbeiro.delete');
    Route::post('/superadmin/tenants/{tenant}/barbeiros/{barbeiroId}/toggle', [\App\Http\Controllers\SuperAdminTenantController::class, 'toggleBarbeiro'])->name('superadmin.barbeiro.toggle');
    Route::post('/superadmin/tenants/{tenant}/servicos', [\App\Http\Controllers\SuperAdminTenantController::class, 'storeServico'])->name('superadmin.servico.store');
    Route::delete('/superadmin/tenants/{tenant}/servicos/{servicoId}', [\App\Http\Controllers\SuperAdminTenantController::class, 'deleteServico'])->name('superadmin.servico.delete');
    Route::post('/superadmin/tenants/{tenant}/servicos/{servicoId}/toggle', [\App\Http\Controllers\SuperAdminTenantController::class, 'toggleServico'])->name('superadmin.servico.toggle');
    Route::post('/superadmin/tenants/{tenant}/notas', [\App\Http\Controllers\SuperAdminTenantController::class, 'updateNotas'])->name('superadmin.notas');
    Route::post('/superadmin/tenants/{tenant}/mensalidade', [\App\Http\Controllers\SuperAdminTenantController::class, 'updateMensalidade'])->name('superadmin.mensalidade');
    Route::post('/superadmin/tenants/{tenant}/renovar-trial', [\App\Http\Controllers\SuperAdminTenantController::class, 'renovarTrial'])->name('superadmin.renovar-trial');
    Route::post('/superadmin/tenants/{tenant}/gerar-pagamento', [\App\Http\Controllers\PagamentoController::class, 'gerarLink'])->name('superadmin.gerar-pagamento');
    Route::post('/superadmin/tenants/{tenant}/toggle-cobranca', [\App\Http\Controllers\PagamentoController::class, 'toggleCobranca'])->name('superadmin.toggle-cobranca');
    Route::post('/superadmin/tenants/{tenant}/dados-cadastrais', [\App\Http\Controllers\SuperAdminTenantController::class, 'updateDadosCadastrais'])->name('superadmin.dados-cadastrais');
    Route::get('/auth/google', [\App\Http\Controllers\GoogleLoginController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [\App\Http\Controllers\GoogleLoginController::class, 'callback']);
    Route::post('/superadmin/tenants/{tenant}/logo', [\App\Http\Controllers\SuperAdminTenantController::class, 'uploadLogo'])->name('superadmin.logo');
    Route::post('/superadmin/tenants/{tenant}/barbeiros/{barbeiroId}/foto', [\App\Http\Controllers\SuperAdminTenantController::class, 'uploadFotoBarbeiro'])->name('superadmin.barbeiro.foto');
    });
