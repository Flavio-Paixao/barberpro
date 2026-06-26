<?php

namespace App\Console\Commands;

use App\Jobs\EnviarLembreteAgendamento;
use Illuminate\Console\Command;

class EnviarLembretes extends Command
{
    protected $signature = 'lembretes:enviar';
    protected $description = 'Envia lembretes de agendamento 1h antes';

    public function handle(): void
    {
        $this->info('Verificando agendamentos...');
        EnviarLembreteAgendamento::dispatch();
        $this->info('Lembretes processados!');
    }
}
