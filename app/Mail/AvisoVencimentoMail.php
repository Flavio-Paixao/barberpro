<?php

namespace App\Mail;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisoVencimentoMail extends Mailable
{
    use Queueable, SerializesModels;

    public Tenant $tenant;
    public int $diasRestantes;
    public ?string $linkPagamento;

    public function __construct(Tenant $tenant, int $diasRestantes, ?string $linkPagamento = null)
    {
        $this->tenant = $tenant;
        $this->diasRestantes = $diasRestantes;
        $this->linkPagamento = $linkPagamento;
    }

    public function build()
    {
        $assunto = $this->diasRestantes === 1
            ? 'Sua mensalidade BarberPro vence amanhã!'
            : "Sua mensalidade BarberPro vence em {$this->diasRestantes} dias";

        return $this->subject($assunto)
            ->view('emails.aviso-vencimento')
            ->with([
                'tenant' => $this->tenant,
                'diasRestantes' => $this->diasRestantes,
                'linkPagamento' => $this->linkPagamento,
            ]);
    }
}
