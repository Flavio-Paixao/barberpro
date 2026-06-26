<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class CriarTenant extends Command
{
    protected $signature = 'tenant:criar {nome} {subdominio} {email?} {--trial=30}';
    protected $description = 'Cria uma nova barbearia no sistema';

    public function handle(): void
    {
        $nome = $this->argument('nome');
        $subdominio = $this->argument('subdominio');
        $email = $this->argument('email') ?? "admin@{$subdominio}.barberpro.tech";
        $trialDias = $this->option('trial');

        // Verifica se subdomínio já existe
        if (Tenant::where('subdominio', $subdominio)->exists()) {
            $this->error("Subdomínio '{$subdominio}' já está em uso!");
            return;
        }

        $this->info("Criando barbearia: {$nome}");

        // Cria o tenant
        $tenant = Tenant::create([
            'nome' => $nome,
            'subdominio' => $subdominio,
            'email' => $email,
            'database' => $subdominio,
            'status' => 'trial',
            'trial_expira_em' => now()->addDays((int) $trialDias),
            'mensalidade' => 49.90,
        ]);

        // Cria a pasta de bancos dos tenants
        $dbDir = database_path('tenants');
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0775, true);
        }

        // Cria o banco SQLite do tenant
        $dbPath = $tenant->getDatabasePath();
        touch($dbPath);
        chmod($dbPath, 0664);

        // Configura conexão com o banco do tenant
        Config::set('database.connections.tenant', [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        DB::purge('tenant');
        DB::setDefaultConnection('tenant');

        // Roda as migrations no banco do tenant
        $this->info("Rodando migrations...");
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations',
            '--force' => true,
        ]);

        // Cria usuário admin do tenant
        $senha = '123456';
        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($senha),
        ]);

        DB::setDefaultConnection('sqlite');

        $this->info("✅ Barbearia criada com sucesso!");
        $this->info("🌐 URL: https://{$subdominio}.barberpro.tech");
        $this->info("📧 Email: {$email}");
        $this->info("🔑 Senha: {$senha}");
        $this->info("📅 Trial: {$trialDias} dias");
    }
}
