<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barbeiros', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('especialidade')->nullable();
            $table->string('telefone')->nullable();
            $table->boolean('ativo')->default(true);
            $table->json('dias_trabalho')->nullable();
            $table->time('hora_inicio')->default('09:00');
            $table->time('hora_fim')->default('18:00');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barbeiros');
    }
};
