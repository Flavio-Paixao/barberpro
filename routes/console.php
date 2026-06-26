<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('lembretes:enviar')->everyMinute();
Schedule::job(new \App\Jobs\VerificarVencimentos())->dailyAt('09:00');
