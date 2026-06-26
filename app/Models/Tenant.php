<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
   protected $fillable = [
    'nome',
    'subdominio',
    'email',
    'telefone',
    'endereco',
    'database',
    'status',
    'trial_expira_em',
    'pagamento_expira_em',
    'mensalidade',
    'logo',
    'whatsapp',
    'notas_internas',
    'cobranca_automatica',
    'mp_payment_id',
    'mp_preference_id',
    'responsavel',
    'horario_abertura',
    'horario_fechamento',
];

    protected $casts = [
        'trial_expira_em' => 'datetime',
        'pagamento_expira_em' => 'datetime',
        'mensalidade' => 'decimal:2',
    ];

    public function isAtivo(): bool
    {
        if ($this->status === 'inativo' || $this->status === 'cancelado') {
            return false;
        }

        if ($this->status === 'trial' && $this->trial_expira_em?->isPast()) {
            return false;
        }

        if ($this->status === 'ativo' && $this->pagamento_expira_em?->isPast()) {
            return false;
        }

        return true;
    }

    public function getDatabasePath(): string
    {
        return database_path('tenants/' . $this->database . '.sqlite');
    }
}
