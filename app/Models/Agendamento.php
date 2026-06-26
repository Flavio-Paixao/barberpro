<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agendamento extends Model
{
    protected $fillable = [
        'barbeiro_id',
        'servico_id',
        'cliente_nome',
        'cliente_telefone',
        'data',
        'horario',
        'status',
        'lembrete_enviado',
        'observacoes',
    ];

    protected $casts = [
        'data' => 'date: d/m/Y',
        'lembrete_enviado' => 'boolean',
    ];

    public function barbeiro(): BelongsTo
    {
        return $this->belongsTo(Barbeiro::class);
    }

    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }
}
