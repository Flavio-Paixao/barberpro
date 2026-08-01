<!DOCTYPE html>
<html lang="pt-BR" style="color-scheme:dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="color-scheme" content="dark"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
  <title>{{ $tenant->nome }} — Super Admin BarberPro</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html,body{background:#000000!important;color-scheme:dark;min-height:100vh}
    body{color:#F8FAFC;font-family:'Inter',sans-serif;font-size:14px;line-height:1.6}
    ::-webkit-scrollbar{width:3px}::-webkit-scrollbar-thumb{background:#DC2626}
    nav{position:sticky;top:0;z-index:100;border-bottom:1px solid #1a1a1a;background:rgba(0,0,0,.97);backdrop-filter:blur(20px);padding:16px 0}
    .container{max-width:1280px;margin:0 auto;padding:0 24px}
    .nav-inner{display:flex;align-items:center;justify-content:space-between}
    .nav-logo{font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:3px;color:#fff;text-decoration:none;display:flex;align-items:center;gap:8px}
    .nav-logo span{color:#DC2626}
    .breadcrumb{font-size:11px;color:#4B5563;font-family:'Space Mono',monospace}
    .breadcrumb a{color:#6B7280;text-decoration:none}
    .page-header{padding:32px 0 20px;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px}
    .page-title{font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:2px;color:#fff;margin-bottom:4px}
    .page-sub{font-size:12px;color:#6B7280}
    .page-sub a{color:#3B82F6;text-decoration:none}
    .badge{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase}
    .badge-trial{background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.3);color:#eab308}
    .badge-ativo{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e}
    .badge-inativo{background:rgba(107,114,128,.15);border:1px solid rgba(107,114,128,.3);color:#9CA3AF}
    .badge-cancelado{background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.3);color:#DC2626}
    .tabs{display:flex;gap:4px;border-bottom:1px solid #1a1a1a;margin-bottom:28px;overflow-x:auto}
    .tab-btn{background:none;border:none;color:#6B7280;font-family:'Inter',sans-serif;font-size:13px;font-weight:600;padding:12px 18px;cursor:pointer;border-bottom:2px solid transparent;transition:all .2s;white-space:nowrap}
    .tab-btn:hover{color:#fff}
    .tab-btn.active{color:#fff;border-bottom-color:#DC2626}
    .tab-content{display:none}
    .tab-content.active{display:block}
    .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}
    .stat-card{background:#0f0f0f;border:1px solid #1a1a1a;border-radius:8px;padding:18px;position:relative;overflow:hidden}
    .stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px}
    .stat-card.blue::before{background:#1D4ED8}
    .stat-card.red::before{background:#DC2626}
    .stat-card.green::before{background:#22c55e}
    .stat-card.yellow::before{background:#eab308}
    .stat-label{font-size:10px;color:#6B7280;letter-spacing:1px;text-transform:uppercase;margin-bottom:6px}
    .stat-value{font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:1px;color:#fff}
    .panel{background:#0f0f0f;border:1px solid #1a1a1a;border-radius:8px;overflow:hidden;margin-bottom:24px}
    .panel-header{padding:18px 22px;border-bottom:1px solid #1a1a1a;display:flex;justify-content:space-between;align-items:center}
    .panel-title{font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1px;color:#fff}
    .panel-body{padding:22px}
    table{width:100%;border-collapse:collapse}
    th{text-align:left;padding:10px 22px;font-size:10px;font-weight:700;color:#6B7280;letter-spacing:1px;text-transform:uppercase;border-bottom:1px solid #1a1a1a;background:#0a0a0a}
    td{padding:12px 22px;font-size:13px;border-bottom:1px solid #161616;color:#D1D5DB}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#131313}
    .btn{position:relative;overflow:hidden;border-radius:6px;font-family:'Inter',sans-serif;font-weight:700;letter-spacing:.3px;padding:9px 16px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .2s;border:none;font-size:11px}
    .btn-sm{padding:6px 12px;font-size:10px}
    .btn-blue{background:#1D4ED8;color:#fff;border:1px solid #1D4ED8}
    .btn-blue:hover{box-shadow:0 4px 15px rgba(29,78,216,.4)}
    .btn-outline{background:transparent;color:#F8FAFC;border:1px solid #1a1a1a}
    .btn-outline:hover{border-color:#3B82F6;color:#3B82F6}
    .btn-red-outline{background:transparent;color:#DC2626;border:1px solid rgba(220,38,38,.3)}
    .btn-red-outline:hover{background:rgba(220,38,38,.1)}
    .btn-green-outline{background:transparent;color:#22c55e;border:1px solid rgba(34,197,94,.3)}
    .btn-green-outline:hover{background:rgba(34,197,94,.1)}
    .form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:14px;margin-bottom:16px}
    .form-group{margin-bottom:0}
    .form-label{font-size:10px;font-weight:700;color:#6B7280;letter-spacing:1px;text-transform:uppercase;margin-bottom:6px;display:block}
    .form-input,.form-select,.form-textarea{width:100%;background:#000!important;border:1px solid #1a1a1a;color:#F8FAFC!important;padding:10px 12px;border-radius:6px;font-size:13px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s}
    .form-input:focus,.form-select:focus,.form-textarea:focus{border-color:#1D4ED8}
    .form-textarea{resize:vertical;min-height:100px}
    .empty-state{padding:40px 22px;text-align:center;color:#6B7280;font-size:13px}
    .status-dot{width:6px;height:6px;border-radius:50%;display:inline-block;margin-right:6px}
    .status-ativo{background:#22c55e}
    .status-inativo{background:#6B7280}
    .alert{padding:14px 20px;border-radius:8px;font-size:13px;margin-bottom:24px;display:flex;align-items:center;gap:10px}
    .alert-success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e}
    .chart-bars{display:flex;align-items:flex-end;gap:12px;height:180px;padding:20px 0}
    .chart-bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:8px;height:100%;justify-content:flex-end}
    .chart-bar{width:100%;max-width:48px;background:linear-gradient(180deg,#DC2626,#1D4ED8);border-radius:4px 4px 0 0;min-height:4px}
    .chart-label{font-size:10px;color:#6B7280;font-family:'Space Mono',monospace}
    .chart-value{font-size:11px;color:#fff;font-weight:700}
    .barber-avatar{width:44px;height:44px;background:linear-gradient(135deg,#DC2626,#1D4ED8);border-radius:6px;display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;color:#fff;font-size:18px;flex-shrink:0}
    .foto-upload-label{display:inline-flex;align-items:center;gap:4px;cursor:pointer;font-size:10px;color:#3B82F6;padding:4px 8px;border:1px solid rgba(59,130,246,.3);border-radius:4px;margin-top:4px;transition:all .2s}
    .foto-upload-label:hover{background:rgba(59,130,246,.1)}
    @media(max-width:1024px){.stats-grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:640px){.stats-grid{grid-template-columns:1fr}table{font-size:11px}th,td{padding:8px 12px}}
  </style>
</head>
<body>

<nav>
  <div class="container">
    <div class="nav-inner">
      <a href="/superadmin" class="nav-logo">BARBER<span>PRO</span></a>
      <div class="breadcrumb"><a href="/superadmin">superadmin</a> / {{ $tenant->subdominio }}</div>
    </div>
  </div>
</nav>

<div class="container" style="padding-bottom:60px">

  @if(session('success'))
  <div class="alert alert-success" style="margin-top:24px">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
  </div>
  @endif

  <div class="page-header">
    <div>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:6px">
        @if($tenant->logo)
        <img src="{{ $tenant->logo }}" style="width:48px;height:48px;object-fit:cover;border-radius:6px">
        @endif
        <h1 class="page-title">{{ $tenant->nome }}</h1>
        @if($tenant->status === 'trial')
          <span class="badge badge-trial">Trial</span>
        @elseif($tenant->status === 'ativo')
          <span class="badge badge-ativo">Ativo</span>
        @elseif($tenant->status === 'inativo')
          <span class="badge badge-inativo">Inativo</span>
        @else
          <span class="badge badge-cancelado">Cancelado</span>
        @endif
      </div>
      <p class="page-sub"><a href="https://{{ $tenant->subdominio }}.barberpro.tech" target="_blank">{{ $tenant->subdominio }}.barberpro.tech</a> · {{ $tenant->email }}</p>
    </div>
    <a href="/superadmin" class="btn btn-outline btn-sm">← Voltar</a>
  </div>

  <div class="stats-grid">
    <div class="stat-card blue"><div class="stat-label">Faturamento Total</div><div class="stat-value">R$ {{ number_format($faturamentoTotal, 0, ',', '.') }}</div></div>
    <div class="stat-card green"><div class="stat-label">Agendamentos</div><div class="stat-value">{{ $totalAgendamentos }}</div></div>
    <div class="stat-card yellow"><div class="stat-label">Profissionais</div><div class="stat-value">{{ $barbeiros->count() }}</div></div>
    <div class="stat-card red"><div class="stat-label">Mensalidade</div><div class="stat-value">R$ {{ number_format($tenant->mensalidade, 0, ',', '.') }}</div></div>
  </div>

  <div class="panel">
    <div class="panel-header"><span class="panel-title">RENOVAR TRIAL</span></div>
    <div class="panel-body">
      <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/renovar-trial" style="display:flex;gap:10px;align-items:flex-end">
        @csrf
        <div style="flex:1;max-width:160px">
          <div class="form-label">Dias de Trial</div>
          <input type="number" name="dias" value="30" min="1" class="form-input"/>
        </div>
        <button type="submit" class="btn btn-blue btn-sm">Renovar Trial</button>
      </form>
    </div>
  </div>

  <div class="panel">
    <div class="panel-header"><span class="panel-title">MODALIDADE DE COBRANÇA</span></div>
    <div class="panel-body">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <div>
          <div style="color:#fff;font-weight:600;margin-bottom:4px">{{ $tenant->cobranca_automatica ? 'Automática (Mercado Pago)' : 'Manual' }}</div>
          <div style="font-size:12px;color:#6B7280">{{ $tenant->cobranca_automatica ? 'O sistema ativa/desativa automaticamente após pagamento' : 'Você controla manualmente pelo botão Ativar/Desativar' }}</div>
        </div>
        <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/toggle-cobranca">
          @csrf
          <button type="submit" class="btn btn-outline btn-sm">{{ $tenant->cobranca_automatica ? 'Mudar para Manual' : 'Mudar para Automática' }}</button>
        </form>
      </div>
      @if($tenant->cobranca_automatica)
      <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/gerar-pagamento">
        @csrf
        <button type="submit" class="btn btn-blue btn-sm">Gerar Link de Pagamento</button>
      </form>
      @if(session('link_pagamento'))
      <div style="margin-top:14px;padding:14px;background:#000;border:1px solid #1a1a1a;border-radius:6px">
        <div class="form-label" style="margin-bottom:8px">Link gerado:</div>
        <a href="{{ session('link_pagamento') }}" target="_blank" style="color:#3B82F6;font-size:12px;word-break:break-all">{{ session('link_pagamento') }}</a>
      </div>
      @endif
      @endif
    </div>
  </div>

  <div class="tabs">
    <button class="tab-btn active" data-tab="geral">Visão Geral</button>
    <button class="tab-btn" data-tab="profissionals">Profissionais</button>
    <button class="tab-btn" data-tab="servicos">Serviços</button>
    <button class="tab-btn" data-tab="agendamentos">Agendamentos</button>
    <button class="tab-btn" data-tab="financeiro">Financeiro</button>
  </div>

  <!-- VISÃO GERAL -->
  <div class="tab-content active" id="tab-geral">

    <div class="panel">
      <div class="panel-header"><span class="panel-title">DADOS CADASTRAIS</span></div>
      <div class="panel-body">
        <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/dados-cadastrais">
          @csrf
          <div class="form-grid">
            <div class="form-group"><label class="form-label">Nome da Barbearia</label><input type="text" name="nome" value="{{ $tenant->nome }}" class="form-input" required/></div>
            <div class="form-group"><label class="form-label">Responsável</label><input type="text" name="responsavel" value="{{ $tenant->responsavel }}" class="form-input" placeholder="Nome do responsável"/></div>
            <div class="form-group"><label class="form-label">E-mail</label><input type="email" name="email" value="{{ $tenant->email }}" class="form-input" required/></div>
            <div class="form-group"><label class="form-label">Telefone</label><input type="text" name="telefone" value="{{ $tenant->telefone }}" class="form-input" placeholder="(13) 99999-9999"/></div>
            <div class="form-group"><label class="form-label">WhatsApp</label><input type="text" name="whatsapp" value="{{ $tenant->whatsapp }}" class="form-input" placeholder="13999999999"/></div>
            <div class="form-group"><label class="form-label">Endereço</label><input type="text" name="endereco" value="{{ $tenant->endereco }}" class="form-input" placeholder="Rua, número, bairro"/></div>
            <div class="form-group"><label class="form-label">Abertura</label><input type="time" name="horario_abertura" value="{{ $tenant->horario_abertura }}" class="form-input"/></div>
            <div class="form-group"><label class="form-label">Fechamento</label><input type="time" name="horario_fechamento" value="{{ $tenant->horario_fechamento }}" class="form-input"/></div>
          </div>
          <button type="submit" class="btn btn-blue btn-sm">Salvar Dados Cadastrais</button>
        </form>
      </div>
    </div>


    <div class="panel">
      <div class="panel-header"><span class="panel-title">VENCIMENTO E MENSALIDADE</span></div>
      <div class="panel-body">
        <div class="form-grid">
          <div><div class="form-label">Vencimento</div><div>{{ $tenant->status === 'trial' ? $tenant->trial_expira_em?->format('d/m/Y') : ($tenant->pagamento_expira_em?->format('d/m/Y') ?? '—') }}</div></div>
          <div><div class="form-label">Cadastrado em</div><div>{{ $tenant->created_at->format('d/m/Y') }}</div></div>
        </div>
        <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/mensalidade" style="display:flex;gap:10px;align-items:flex-end;margin-top:16px">
          @csrf
          <div style="flex:1;max-width:200px">
            <div class="form-label">Mensalidade (R$)</div>
            <input type="number" step="0.01" name="mensalidade" value="{{ $tenant->mensalidade }}" class="form-input"/>
          </div>
          <button type="submit" class="btn btn-blue btn-sm">Atualizar</button>
        </form>
      </div>
    </div>

    <div class="panel">
      <div class="panel-header"><span class="panel-title">NOTAS INTERNAS</span></div>
      <div class="panel-body">
        <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/notas">
          @csrf
          <textarea name="notas_internas" class="form-textarea" placeholder="Anotações sobre esse cliente, histórico de conversas, particularidades...">{{ $tenant->notas_internas }}</textarea>
          <button type="submit" class="btn btn-outline btn-sm" style="margin-top:12px">Salvar Notas</button>
        </form>
      </div>
    </div>
  </div>

  <!-- PROFISSIONAIS CADASTRADOS -->
  <div class="tab-content" id="tab-profissionals">
    <div class="panel">
      <div class="panel-header"><span class="panel-title">ADICIONAR PROFISSIONAL</span></div>
      <div class="panel-body">
        <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/profissionals">
          @csrf
          <div class="form-grid">
            <div class="form-group"><label class="form-label">Nome</label><input type="text" name="nome" class="form-input" required/></div>
            <div class="form-group"><label class="form-label">Especialidade</label><input type="text" name="especialidade" class="form-input" placeholder="Ex: Degradê"/></div>
            <div class="form-group"><label class="form-label">Início</label><input type="time" name="hora_inicio" class="form-input" value="09:00" required/></div>
            <div class="form-group"><label class="form-label">Fim</label><input type="time" name="hora_fim" class="form-input" value="18:00" required/></div>
          </div>
          <button type="submit" class="btn btn-blue">+ Adicionar Profissional</button>
        </form>
      </div>
    </div>

    <div class="panel">
      <div class="panel-header"><span class="panel-title">PROFISSIONAIS CADASTRADOS</span></div>
      @if($barbeiros->count() > 0)
      <table>
        <thead><tr><th>Nome</th><th>Especialidade</th><th>Horário</th><th>Status</th><th>Ações</th></tr></thead>
        <tbody>
          @foreach($barbeiros as $b)
          <tr>
            
            <td style="font-weight:600;color:#fff">{{ $b->nome }}</td>
            <td>{{ $b->especialidade ?? '—' }}</td>
            <td>{{ $b->hora_inicio }} - {{ $b->hora_fim }}</td>
            <td><span class="status-dot {{ $b->ativo ? 'status-ativo' : 'status-inativo' }}"></span>{{ $b->ativo ? 'Ativo' : 'Inativo' }}</td>
            <td style="vertical-align:middle">
  <div style="display:flex;gap:6px">
  <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/profissionals/{{ $b->id }}/toggle">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">{{ $b->ativo ? 'Desativar' : 'Ativar' }}</button>
              </form>
              <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/profissionals/{{ $b->id }}" onsubmit="return confirm('Remover este profissional?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-red-outline btn-sm">Remover</button>
              </form>
            </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="empty-state">Nenhum profissional cadastrado ainda.</div>
      @endif
    </div>
  </div>

  <!-- SERVIÇOS -->
  <div class="tab-content" id="tab-servicos">
    <div class="panel">
      <div class="panel-header"><span class="panel-title">ADICIONAR SERVIÇO</span></div>
      <div class="panel-body">
        <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/servicos">
          @csrf
          <div class="form-grid">
            <div class="form-group"><label class="form-label">Nome</label><input type="text" name="nome" class="form-input" required/></div>
            <div class="form-group"><label class="form-label">Preço (R$)</label><input type="number" step="0.01" name="preco" class="form-input" required/></div>
            <div class="form-group"><label class="form-label">Duração (min)</label><input type="number" name="duracao_minutos" class="form-input" value="60" required/></div>
          </div>
          <button type="submit" class="btn btn-blue">+ Adicionar Serviço</button>
        </form>
      </div>
    </div>

    <div class="panel">
      <div class="panel-header"><span class="panel-title">SERVIÇOS CADASTRADOS</span></div>
      @if($servicos->count() > 0)
      <table>
        <thead><tr><th>Nome</th><th>Preço</th><th>Duração</th><th>Status</th><th>Ações</th></tr></thead>
        <tbody>
          @foreach($servicos as $s)
          <tr>
            <td style="font-weight:600;color:#fff">{{ $s->nome }}</td>
            <td>R$ {{ number_format($s->preco, 2, ',', '.') }}</td>
            <td>{{ $s->duracao_minutos }}min</td>
            <td><span class="status-dot {{ $s->ativo ? 'status-ativo' : 'status-inativo' }}"></span>{{ $s->ativo ? 'Ativo' : 'Inativo' }}</td>
            <td style="display:flex;gap:6px">
              <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/servicos/{{ $s->id }}/toggle">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">{{ $s->ativo ? 'Desativar' : 'Ativar' }}</button>
              </form>
              <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/servicos/{{ $s->id }}" onsubmit="return confirm('Remover este serviço?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-red-outline btn-sm">Remover</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="empty-state">Nenhum serviço cadastrado ainda.</div>
      @endif
    </div>
  </div>

  <!-- AGENDAMENTOS -->
  <div class="tab-content" id="tab-agendamentos">
    <div class="panel">
      <div class="panel-header"><span class="panel-title">HISTÓRICO DE AGENDAMENTOS</span></div>
      @if($agendamentos->count() > 0)
      <table>
        <thead><tr><th>Cliente</th><th>Telefone</th><th>Data</th><th>Horário</th><th>Status</th></tr></thead>
        <tbody>
          @foreach($agendamentos as $a)
          <tr>
            <td>{{ $a->cliente_nome }}</td>
            <td>{{ $a->cliente_telefone }}</td>
            <td>{{ \Carbon\Carbon::parse($a->data)->format('d/m/Y') }}</td>
            <td>{{ $a->horario }}</td>
            <td>{{ ucfirst($a->status) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="empty-state">Nenhum agendamento ainda.</div>
      @endif
    </div>
  </div>

  <!-- FINANCEIRO -->
  <div class="tab-content" id="tab-financeiro">
    <div class="panel">
      <div class="panel-header"><span class="panel-title">FATURAMENTO — ÚLTIMOS 6 MESES</span></div>
      <div class="panel-body">
        <div class="chart-bars">
          @php $max = collect($faturamentoMensal)->max('total') ?: 1; @endphp
          @foreach($faturamentoMensal as $f)
          <div class="chart-bar-wrap">
            <div class="chart-value">R$ {{ number_format($f['total'], 0, ',', '.') }}</div>
            <div class="chart-bar" style="height:{{ $f['total'] > 0 ? max(($f['total']/$max)*140, 4) : 4 }}px"></div>
            <div class="chart-label">{{ $f['mes'] }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</div>

<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
  });
});
document.addEventListener('gesturestart', function(e) { e.preventDefault(); });
</script>
</body>
</html>
