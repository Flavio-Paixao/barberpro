<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->boolean('cobranca_automatica')->default(false);
            $table->string('mp_payment_id')->nullable();
            $table->string('mp_preference_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['cobranca_automatica', 'mp_payment_id', 'mp_preference_id']);
        });
    }
};
