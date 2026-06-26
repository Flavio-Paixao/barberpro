<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $hoje = Carbon::today();
        $mesAtual = Carbon::now()->startOfMonth();

        $agendamentosHoje = Agendamento::whereDate('data', $hoje)->count();
        $confirmadosHoje = Agendamento::whereDate('data', $hoje)->where('status', 'confirmado')->count();
        $faturamentoHoje = Agendamento::whereDate('data', $hoje)
            ->whereIn('status', ['confirmado', 'pendente'])
            ->with('servico')
            ->get()
            ->sum(fn($a) => $a->servico?->preco ?? 0);
        $faturamentoMes = Agendamento::where('data', '>=', $mesAtual)
            ->whereIn('status', ['confirmado', 'pendente'])
            ->with('servico')
            ->get()
            ->sum(fn($a) => $a->servico?->preco ?? 0);
        $pendentes = Agendamento::where('status', 'pendente')->whereDate('data', '>=', $hoje)->count();

        return [
            Stat::make('Agendamentos Hoje', $agendamentosHoje)
                ->description('Total do dia')
                ->color('primary')
                ->icon('heroicon-o-calendar'),

            Stat::make('Confirmados Hoje', $confirmadosHoje)
                ->description('De ' . $agendamentosHoje . ' agendamentos')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Faturamento Hoje', 'R$ ' . number_format($faturamentoHoje, 2, ',', '.'))
                ->description('Estimado')
                ->color('warning')
                ->icon('heroicon-o-currency-dollar'),

            Stat::make('Faturamento do Mês', 'R$ ' . number_format($faturamentoMes, 2, ',', '.'))
                ->description('Mês atual')
                ->color('success')
                ->icon('heroicon-o-chart-bar'),

            Stat::make('Pendentes', $pendentes)
                ->description('Aguardando confirmação')
                ->color('danger')
                ->icon('heroicon-o-clock'),
        ];
    }
}
