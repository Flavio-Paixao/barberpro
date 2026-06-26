<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barbeiro extends Model
{
    protected $fillable = [
        'nome',
        'especialidade',
        'telefone',
        'ativo',
        'dias_trabalho',
        'hora_inicio',
        'hora_fim',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'dias_trabalho' => 'array',
    ];

    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class);
    }
}
