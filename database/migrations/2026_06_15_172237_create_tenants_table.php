<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('subdominio')->unique();
            $table->string('email');
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable();
            $table->string('database');
            $table->enum('status', ['trial', 'ativo', 'inativo', 'cancelado'])->default('trial');
            $table->timestamp('trial_expira_em')->nullable();
            $table->timestamp('pagamento_expira_em')->nullable();
            $table->decimal('mensalidade', 8, 2)->default(49.90);
            $table->string('logo')->nullable();
            $table->string('whatsapp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
