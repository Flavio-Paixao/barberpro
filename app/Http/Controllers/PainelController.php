<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Barbeiro;
use App\Models\Servico;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PainelController extends Controller
{
    public function __construct()
{
    view()->composer('painel.*', function ($view) {
        $pendentes = \App\Models\Agendamento::where('status', 'pendente')
            ->whereDate('data', '>=', \Carbon\Carbon::today())
            ->count();
        $view->with('pendentes', $pendentes);
    });
}

    public function index()
    {
        $hoje = Carbon::today();
        $mesAtual = Carbon::now()->startOfMonth();

        $dados = [
            'agendamentos_hoje' => Agendamento::whereDate('data', $hoje)->count(),
            'confirmados_hoje' => Agendamento::whereDate('data', $hoje)->where('status', 'confirmado')->count(),
            'pendentes' => Agendamento::where('status', 'pendente')->whereDate('data', '>=', $hoje)->count(),
            'faturamento_hoje' => Agendamento::whereDate('data', $hoje)
                ->whereIn('status', ['confirmado', 'pendente'])
                ->with('servico')->get()
                ->sum(fn($a) => $a->servico?->preco ?? 0),
            'faturamento_mes' => Agendamento::where('data', '>=', $mesAtual)
                ->whereIn('status', ['confirmado', 'pendente'])
                ->with('servico')->get()
                ->sum(fn($a) => $a->servico?->preco ?? 0),
            'proximos' => Agendamento::with(['barbeiro', 'servico'])
                ->whereDate('data', $hoje)
                ->orderBy('horario')
                ->get(),
            'pendentes_lista' => Agendamento::with(['barbeiro', 'servico'])
                ->where('status', 'pendente')
                ->whereDate('data', '>=', $hoje)
                ->orderBy('data')
                ->orderBy('horario')
                ->take(10)
                ->get(),
        ];

        return view('painel.index', $dados);
    }

    public function agendamentos()
    {
        $agendamentos = Agendamento::with(['barbeiro', 'servico'])
            ->orderByDesc('data')
            ->orderByDesc('horario')
            ->paginate(20);

        return view('painel.agendamentos', compact('agendamentos'));
    }

    public function financeiro()
    {
        $meses = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $faturamento = Agendamento::whereYear('data', $mes->year)
                ->whereMonth('data', $mes->month)
                ->whereIn('status', ['confirmado', 'pendente'])
                ->with('servico')->get()
                ->sum(fn($a) => $a->servico?->preco ?? 0);
            $meses[] = ['mes' => $mes->format('M/y'), 'faturamento' => $faturamento];
        }

        $totalMes = Agendamento::where('data', '>=', Carbon::now()->startOfMonth())
            ->whereIn('status', ['confirmado', 'pendente'])
            ->with('servico')->get()->sum(fn($a) => $a->servico?->preco ?? 0);

        $ticketMedio = Agendamento::whereIn('status', ['confirmado', 'pendente'])
            ->with('servico')->get()->avg(fn($a) => $a->servico?->preco ?? 0);

        $naoCompareceram = Agendamento::where('status', 'nao_compareceu')
            ->where('data', '>=', Carbon::now()->startOfMonth())->count();

        return view('painel.financeiro', compact('meses', 'totalMes', 'ticketMedio', 'naoCompareceram'));
    }

    public function barbeiros()
    {
        $barbeiros = Barbeiro::withCount('agendamentos')->get();
        return view('painel.barbeiros', compact('barbeiros'));
    }

    public function servicos()
    {
        $servicos = Servico::withCount('agendamentos')->get();
        return view('painel.servicos', compact('servicos'));
    }

    public function atualizarStatus(Request $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->update(['status' => $request->status]);
        return response()->json(['sucesso' => true]);
    }
}
