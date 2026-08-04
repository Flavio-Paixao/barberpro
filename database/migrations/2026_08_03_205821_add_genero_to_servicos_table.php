<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicos', function (Blueprint $table) {
            $table->enum('genero', ['masculino', 'feminino', 'ambos'])->default('ambos')->after('ativo');
        });
    }
    public function down(): void
    {
        Schema::table('servicos', function (Blueprint $table) {
            $table->dropColumn('genero');
        });
    }
};
