<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $mainDomain = config('app.domain', 'barberpro.tech');

        // Se for o domínio principal, não aplica tenant
        // Se for o domínio principal, não aplica tenant
   if (
    $host === $mainDomain ||
    $host === 'www.' . $mainDomain ||
    $host === 'app.' . $mainDomain ||
    $host === 'localhost' ||
    $host === '127.0.0.1'
) {
    return $next($request);
}

        // Extrai o subdomínio
        $subdominio = str_replace('.' . $mainDomain, '', $host);

        // Busca o tenant
        $tenant = Tenant::where('subdominio', $subdominio)->first();

        if (!$tenant) {
            abort(404, 'Barbearia não encontrada.');
        }

        if (!$tenant->isAtivo()) {
            abort(403, 'Esta barbearia está inativa. Entre em contato com o suporte.');
        }

        // Configura o banco do tenant
        $dbPath = $tenant->getDatabasePath();

        Config::set('database.connections.tenant', [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        DB::purge('tenant');
        DB::setDefaultConnection('tenant');

        // Disponibiliza o tenant para toda a aplicação
        app()->instance('tenant', $tenant);

        return $next($request);
    }
}
