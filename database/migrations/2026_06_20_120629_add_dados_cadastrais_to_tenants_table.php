<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('responsavel')->nullable();
            $table->time('horario_abertura')->nullable();
            $table->time('horario_fechamento')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['responsavel', 'horario_abertura', 'horario_fechamento']);
        });
    }
};
