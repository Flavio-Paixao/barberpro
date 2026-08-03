<!DOCTYPE html>
<html lang="pt-BR" style="color-scheme:dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="color-scheme" content="dark"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
  <title>Super Admin — StudioPro</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
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
    .nav-badge{background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.3);color:#DC2626;font-size:10px;font-weight:700;letter-spacing:1px;padding:3px 10px;border-radius:20px;text-transform:uppercase}
    .nav-actions{display:flex;gap:12px;align-items:center}

    .page-header{padding:40px 0 24px}
    .page-title{font-family:'Bebas Neue',sans-serif;font-size:40px;letter-spacing:2px;color:#fff;margin-bottom:6px}
    .page-title span{color:#3B82F6}
    .page-sub{font-size:13px;color:#6B7280}

    .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px}
    .stat-card{background:#0f0f0f;border:1px solid #1a1a1a;border-radius:8px;padding:20px;position:relative;overflow:hidden}
    .stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px}
    .stat-card.blue::before{background:#1D4ED8}
    .stat-card.red::before{background:#DC2626}
    .stat-card.green::before{background:#22c55e}
    .stat-card.yellow::before{background:#eab308}
    .stat-label{font-size:11px;color:#6B7280;letter-spacing:1px;text-transform:uppercase;margin-bottom:8px}
    .stat-value{font-family:'Bebas Neue',sans-serif;font-size:32px;letter-spacing:1px;color:#fff}

    .panel{background:#0f0f0f;border:1px solid #1a1a1a;border-radius:8px;overflow:hidden;margin-bottom:32px}
    .panel-header{padding:20px 24px;border-bottom:1px solid #1a1a1a;display:flex;justify-content:space-between;align-items:center}
    .panel-title{font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:1px;color:#fff}

    table{width:100%;border-collapse:collapse}
    th{text-align:left;padding:12px 24px;font-size:10px;font-weight:700;color:#6B7280;letter-spacing:1px;text-transform:uppercase;border-bottom:1px solid #1a1a1a;background:#0a0a0a}
    td{padding:14px 24px;font-size:13px;border-bottom:1px solid #161616;color:#D1D5DB}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#131313}

    .tenant-name{color:#fff;font-weight:600}
    .tenant-sub{font-size:11px;color:#6B7280;margin-top:2px}
    .tenant-link{color:#3B82F6;text-decoration:none;font-size:12px}
    .tenant-link:hover{text-decoration:underline}

    .badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase}
    .badge-trial{background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.3);color:#eab308}
    .badge-ativo{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e}
    .badge-inativo{background:rgba(107,114,128,.15);border:1px solid rgba(107,114,128,.3);color:#9CA3AF}
    .badge-cancelado{background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.3);color:#DC2626}
    .badge-dot{width:5px;height:5px;border-radius:50%;background:currentColor}

    .btn{position:relative;overflow:hidden;border-radius:6px;font-family:'Inter',sans-serif;font-weight:700;letter-spacing:.3px;padding:9px 16px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .2s;border:none;font-size:11px}
    .btn-sm{padding:7px 12px;font-size:11px}
    .btn-blue{background:#1D4ED8;color:#fff;border:1px solid #1D4ED8}
    .btn-blue:hover{box-shadow:0 4px 15px rgba(29,78,216,.4);transform:translateY(-1px)}
    .btn-outline{background:transparent;color:#F8FAFC;border:1px solid #1a1a1a}
    .btn-outline:hover{border-color:#3B82F6;color:#3B82F6}
    .btn-red-outline{background:transparent;color:#DC2626;border:1px solid rgba(220,38,38,.3)}
    .btn-red-outline:hover{background:rgba(220,38,38,.1)}
    .btn-green-outline{background:transparent;color:#22c55e;border:1px solid rgba(34,197,94,.3)}
    .btn-green-outline:hover{background:rgba(34,197,94,.1)}

    .empty-state{padding:60px 24px;text-align:center;color:#6B7280}
    .empty-state svg{margin-bottom:16px;opacity:.3}

    .alert{padding:14px 20px;border-radius:8px;font-size:13px;margin-bottom:24px;display:flex;align-items:center;gap:10px}
    .alert-success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e}

    @media(max-width:1024px){.stats-grid{grid-template-columns:repeat(2,1fr)}table{font-size:12px}th,td{padding:10px 14px}}
    @media(max-width:640px){.stats-grid{grid-template-columns:1fr}.nav-links{display:none}}
  </style>
</head>
<body>

<nav>
  <div class="container">
    <div class="nav-inner">
      <a href="/" class="nav-logo">STUDIO<span>PRO</span> <span class="nav-badge">Super Admin</span></a>
      <div class="nav-actions">
        <span style="font-size:12px;color:#6B7280">{{ auth()->user()->name ?? 'Admin' }}</span>
        <form method="POST" action="/logout" style="margin:0">
          @csrf
          <button type="submit" class="btn btn-outline btn-sm">Sair</button>
        </form>
      </div>
    </div>
  </div>
</nav>

<div class="container">

  <div class="page-header">
    <h1 class="page-title">PAINEL <span>SUPER ADMIN</span></h1>
    <p class="page-sub">// Gerencie todas as barbearias cadastradas no StudioPro</p>
  </div>

  @if(session('success'))
  <div class="alert alert-success">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
  </div>
  @endif

  <div class="stats-grid">
    <div class="stat-card blue">
      <div class="stat-label">Total de Barbearias</div>
      <div class="stat-value">{{ $tenants->count() }}</div>
    </div>
    <div class="stat-card green">
      <div class="stat-label">Ativas</div>
      <div class="stat-value">{{ $tenants->where('status', 'ativo')->count() }}</div>
    </div>
    <div class="stat-card yellow">
      <div class="stat-label">Em Trial</div>
      <div class="stat-value">{{ $tenants->where('status', 'trial')->count() }}</div>
    </div>
    <div class="stat-card red">
      <div class="stat-label">Inativas</div>
      <div class="stat-value">{{ $tenants->whereIn('status', ['inativo','cancelado'])->count() }}</div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-header">
      <span class="panel-title">BARBEARIAS CADASTRADAS</span>
      <span style="font-size:11px;color:#6B7280">{{ $tenants->count() }} no total</span>
    </div>

    @if($tenants->count() > 0)
    <table>
      <thead>
        <tr>
          <th>Barbearia</th>
          <th>Status</th>
          <th>Vencimento</th>
          <th>Mensalidade</th>
          <th>Cadastrado em</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tenants as $tenant)
        <tr>
          <td>
            <div class="tenant-name">{{ $tenant->nome }}</div>
            <div class="tenant-sub">
              <a href="https://{{ $tenant->subdominio }}.studiopro.tech" target="_blank" class="tenant-link">{{ $tenant->subdominio }}.studiopro.tech</a>
            </div>
          </td>
          <td>
            @if($tenant->status === 'trial')
              <span class="badge badge-trial"><span class="badge-dot"></span>Trial</span>
            @elseif($tenant->status === 'ativo')
              <span class="badge badge-ativo"><span class="badge-dot"></span>Ativo</span>
            @elseif($tenant->status === 'inativo')
              <span class="badge badge-inativo"><span class="badge-dot"></span>Inativo</span>
            @else
              <span class="badge badge-cancelado"><span class="badge-dot"></span>Cancelado</span>
            @endif
          </td>
          <td>
            @if($tenant->status === 'trial' && $tenant->trial_expira_em)
              {{ $tenant->trial_expira_em->format('d/m/Y') }}
            @elseif($tenant->pagamento_expira_em)
              {{ $tenant->pagamento_expira_em->format('d/m/Y') }}
            @else
              —
            @endif
          </td>
          <td>R$ {{ number_format($tenant->mensalidade, 2, ',', '.') }}</td>
          <td>{{ $tenant->created_at->format('d/m/Y') }}</td>
          <td style="display:flex;gap:6px">
  <a href="/superadmin/tenants/{{ $tenant->id }}" class="btn btn-blue btn-sm">Ver Detalhes</a>
  <form method="POST" action="/superadmin/tenants/{{ $tenant->id }}/toggle" style="display:inline">
    @csrf
    @if($tenant->status === 'inativo')
      <button type="submit" class="btn btn-green-outline btn-sm">Ativar</button>
    @else
      <button type="submit" class="btn btn-red-outline btn-sm">Desativar</button>
    @endif
  </form>
</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="empty-state">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/></svg>
      <p>Nenhuma barbearia cadastrada ainda.</p>
      <p style="font-size:11px;margin-top:8px">Use o comando: <code style="color:#3B82F6">php artisan tenant:criar "Nome" subdominio</code></p>
    </div>
    @endif
  </div>

</div>

</body>
</html>
