<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barbeiro_id')->constrained('barbeiros')->onDelete('cascade');
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->string('cliente_nome');
            $table->string('cliente_telefone');
            $table->date('data');
            $table->time('horario');
            $table->enum('status', ['pendente', 'confirmado', 'cancelado', 'nao_compareceu'])->default('pendente');
            $table->boolean('lembrete_enviado')->default(false);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
