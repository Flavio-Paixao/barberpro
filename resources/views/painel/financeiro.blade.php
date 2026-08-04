<!DOCTYPE html>
<html lang="pt-BR" style="color-scheme:dark">
<head>
  <meta charset="UTF-8"/><meta name="color-scheme" content="dark"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>StudioPro — Financeiro</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&display=swap');
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--bg:#000000;--surface:#0f0f0f;--border:#1a1a1a;--gold:#C9A84C;--gold-dark:#A07830;--gold-light:#E8C96D;--white:#FFFFFF;--text:#F8FAFC;--muted:#6B7280;--green:#22c55e;--yellow:#fbbf24}
    html,body{background:#000000!important;color-scheme:dark;height:100%}
    body{color:var(--text);font-family:'Inter',sans-serif;font-size:13px;line-height:1.6;overflow-x:hidden}
    ::-webkit-scrollbar{width:3px}::-webkit-scrollbar-thumb{background:var(--gold)}
    .glitch{position:relative;display:inline-block;font-family:'Bebas Neue',sans-serif}
    .glitch::before,.glitch::after{content:attr(data-text);position:absolute;top:0;left:0;width:100%;height:100%;font-family:'Bebas Neue',sans-serif;font-size:inherit;font-weight:inherit}
    .glitch::before{color:var(--gold-light);clip-path:polygon(0 0,100% 0,100% 35%,0 35%);animation:glitch1 2.5s infinite}
    .glitch::after{color:var(--gold);clip-path:polygon(0 65%,100% 65%,100% 100%,0 100%);animation:glitch2 2.5s infinite;opacity:.7}
    @keyframes glitch1{0%,85%,100%{transform:translateX(0);opacity:0}87%{transform:translateX(-4px);opacity:.9}92%{transform:translateX(2px);opacity:.6}}
    @keyframes glitch2{0%,85%,100%{transform:translateX(0);opacity:0}88%{transform:translateX(4px);opacity:.8}93%{transform:translateX(-2px);opacity:.5}}
    .btn{position:relative;overflow:hidden;border-radius:6px;font-family:'Inter',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;padding:8px 16px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .2s ease-in;border:none;box-shadow:0 4px 12px rgba(0,0,0,0.4),inset 0 1px 0 rgba(255,255,255,0.06)}
    .btn::before{content:'';display:block;width:0;height:86%;position:absolute;top:7%;left:0;opacity:0;background:#fff;box-shadow:0 0 50px 30px #fff;transform:skewX(-20deg)}
    .btn:hover{transform:translateY(-2px)}
    .btn:hover::before{animation:sh02 .5s linear}
    @keyframes sh02{from{opacity:0;left:0%}50%{opacity:1}to{opacity:0;left:100%}}
    .btn-blue{background:var(--gold-dark);color:var(--white);border:1px solid var(--gold-dark)}
    .btn-blue:hover{box-shadow:0 8px 20px rgba(29,78,216,.5);transition:all .2s ease-out}
    .btn-outline-blue{background:transparent;color:var(--gold-light);border:1px solid var(--gold-dark)}
    .btn-outline-blue:hover{background:var(--gold-dark);color:var(--white);transition:all .2s ease-out}
    .btn-green{background:var(--green);color:#000;border:1px solid var(--green)}
    .btn-green:hover{box-shadow:0 8px 20px rgba(34,197,94,.5);transition:all .2s ease-out}
    .btn-red-soft{background:rgba(220,38,38,.1);color:var(--gold);border:1px solid var(--gold)}
    .btn-red-soft:hover{background:var(--gold);color:var(--white);transition:all .2s ease-out}
    .sidebar{width:240px;background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:50}
    .sidebar-logo{padding:20px;border-bottom:1px solid var(--border);font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:3px;color:var(--white)}
    .sidebar-logo .pro{color:var(--gold)}
    .sidebar-nav{flex:1;padding:12px 0;overflow-y:auto}
    .nav-section{padding:8px 20px 4px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted)}
    .nav-item{display:flex;align-items:center;gap:10px;padding:10px 20px;color:var(--muted);transition:all .2s;font-size:11px;font-weight:700;letter-spacing:.5px;border-left:2px solid transparent;text-transform:uppercase;text-decoration:none}
    .nav-item:hover{color:var(--white);background:rgba(29,78,216,.05)}
    .nav-item.active{color:var(--gold-light);background:rgba(29,78,216,.08);border-left-color:var(--gold-dark)}
    .nav-badge{margin-left:auto;background:var(--gold);color:var(--white);font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px}
    .sidebar-footer{padding:16px 20px;border-top:1px solid var(--border)}
    .user-info{display:flex;align-items:center;gap:10px}
    .user-avatar{width:32px;height:32px;background:var(--gold-dark);display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:14px;color:var(--white);flex-shrink:0;border-radius:4px}
    .user-name{font-size:12px;font-weight:700;color:var(--white)}
    .user-role{font-size:10px;color:var(--muted)}
    .main{margin-left:240px;min-height:100vh;display:flex;flex-direction:column}
    .topbar{background:var(--surface);border-bottom:1px solid var(--border);padding:16px 32px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
    .topbar-title{font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:2px;color:var(--white)}
    .topbar-sub{font-size:11px;color:var(--muted);letter-spacing:.5px}
    .content{flex:1;padding:28px 32px}
    .metrics-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:24px}
    .metric-card{background:var(--surface);border:1px solid var(--border);padding:20px;position:relative;overflow:hidden;border-radius:4px}
    .metric-card::before{content:'';position:absolute;bottom:0;left:0;right:0;height:2px}
    .metric-card.red::before{background:var(--gold)}
    .metric-card.blue::before{background:var(--gold-dark)}
    .metric-card.green::before{background:var(--green)}
    .metric-card.yellow::before{background:var(--yellow)}
    .metric-label{font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-bottom:8px}
    .metric-value{font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:1px;color:var(--white);line-height:1;margin-bottom:4px}
    .metric-desc{font-size:11px;color:var(--muted)}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px}
    .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:24px}
    .card{background:var(--surface);border:1px solid var(--border);padding:24px;border-radius:4px;margin-bottom:24px}
    .card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
    .card-title{font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:1px;color:var(--white)}
    .card-sub{font-size:11px;color:var(--muted);margin-top:2px}
    table{width:100%;border-collapse:collapse}
    thead th{font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted);padding:10px 12px;text-align:left;border-bottom:1px solid var(--border)}
    tbody td{padding:11px 12px;font-size:12px;border-bottom:1px solid rgba(26,26,26,.8)}
    tbody tr:hover{background:rgba(29,78,216,.03)}
    .badge{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:3px 8px;border-radius:4px}
    .badge-green{color:var(--green);border:1px solid rgba(34,197,94,.3);background:rgba(34,197,94,.08)}
    .badge-red{color:var(--gold);border:1px solid rgba(220,38,38,.3);background:rgba(220,38,38,.08)}
    .badge-blue{color:var(--gold-light);border:1px solid rgba(59,130,246,.3);background:rgba(59,130,246,.08)}
    .badge-yellow{color:var(--yellow);border:1px solid rgba(251,191,36,.3);background:rgba(251,191,36,.08)}
    .pending-item{background:#000;border:1px solid var(--border);border-left:3px solid var(--gold);padding:14px 16px;display:flex;align-items:center;gap:14px;margin-bottom:10px;border-radius:0 4px 4px 0}
    .pending-info{flex:1}
    .pending-name{font-size:13px;font-weight:700;margin-bottom:2px;color:var(--white)}
    .pending-detail{font-size:11px;color:var(--muted)}
    .pending-actions{display:flex;gap:8px}
    .bar-chart{display:flex;align-items:flex-end;gap:8px;height:120px;padding:0 4px}
    .bar-group{flex:1;display:flex;flex-direction:column;align-items:center;gap:6px}
    .bar{width:100%;background:var(--gold-dark);border-radius:2px 2px 0 0;min-height:4px;opacity:.85}
    .bar:hover{opacity:1}
    .bar-label{font-size:10px;color:var(--muted)}
    .barber-card{background:#000;border:1px solid var(--border);padding:20px;display:flex;flex-direction:column;gap:12px;border-radius:4px}
    .barber-header{display:flex;align-items:center;gap:12px}
    .barber-avatar{width:44px;height:44px;background:linear-gradient(135deg,var(--gold),var(--gold-dark));display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:16px;color:var(--white);flex-shrink:0;border-radius:4px}
    .barber-name{font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1px;color:var(--white)}
    .barber-spec{font-size:11px;color:var(--gold)}
    .toggle{position:relative;width:40px;height:22px;display:inline-block}
    .toggle input{display:none}
    .toggle-slider{position:absolute;inset:0;background:var(--border);cursor:pointer;transition:.3s;border-radius:2px}
    .toggle-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:var(--muted);transition:.3s}
    .toggle input:checked + .toggle-slider{background:rgba(34,197,94,.3);border:1px solid var(--green)}
    .toggle input:checked + .toggle-slider::before{background:var(--green);transform:translateX(18px)}
    .service-item{background:#000;border:1px solid var(--border);padding:16px;display:flex;align-items:center;gap:16px;margin-bottom:10px;border-radius:4px}
    .service-name{font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1px;color:var(--white);flex:1}
    .service-price{font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:1px;color:var(--gold);min-width:70px;text-align:right}
    .service-time{font-size:11px;color:var(--muted);min-width:50px;text-align:center}
    @media(max-width:1200px){.metrics-grid{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:768px){.sidebar{transform:translateX(-100%)}.main{margin-left:0}.metrics-grid{grid-template-columns:repeat(2,1fr)}.grid-2,.grid-3{grid-template-columns:1fr}}
</style>
</head>
<body><aside class="sidebar">
  <div class="sidebar-logo">STUDIO<span class="pro">PRO</span></div>
  <nav class="sidebar-nav"><div class="nav-section">Principal</div><a href="{{ route('painel') }}" class="nav-item "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> Dashboard</a><a href="{{ route('painel.agendamentos') }}" class="nav-item "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> Agendamentos @if($pendentes > 0)<span class="nav-badge">{{ $pendentes }}</span>@endif</a><div class="nav-section">Financeiro</div><a href="{{ route('painel.financeiro') }}" class="nav-item active"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg> Financeiro</a><div class="nav-section">Gestão</div><a href="{{ route('painel.barbeiros') }}" class="nav-item "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> Profissionais</a><a href="{{ route('painel.servicos') }}" class="nav-item "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg> Serviços</a></nav>
  <div class="sidebar-footer">
    <div class="user-info">
      <div class="user-avatar">A</div>
      <div><div class="user-name">{{ auth()->user()->name }}</div><div class="user-role">Administrador</div></div>
      <form method="POST" action="/logout" style="margin-left:auto">
        @csrf
        <button type="submit" style="background:transparent;border:none;color:var(--muted);cursor:pointer;padding:4px;transition:color .2s" onmouseover="this.style.color='#DC2626'" onmouseout="this.style.color='#6B7280'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></button>
      </form>
    </div>
  </div>
</aside>
<main class="main">
  <div class="topbar">
    <div>
      <div class="topbar-title"><span class="glitch" data-text="FINANCEIRO">FINAN<span style="color:var(--gold-light)">CEIRO</span></span></div>
      <div class="topbar-sub">// Histórico de lucro</div>
    </div>
  </div>
  <div class="content">
    <div class="grid-3">
      <div class="metric-card red"><div class="metric-label">Faturamento do Mês</div><div class="metric-value" style="font-size:22px">R$ {{ number_format($totalMes, 2, ',', '.') }}</div><div class="metric-desc">Mês atual</div></div>
      <div class="metric-card green"><div class="metric-label">Ticket Médio</div><div class="metric-value" style="font-size:22px">R$ {{ number_format($ticketMedio ?? 0, 2, ',', '.') }}</div><div class="metric-desc">Por atendimento</div></div>
      <div class="metric-card blue"><div class="metric-label">Não Compareceram</div><div class="metric-value" style="font-size:22px;color:var(--gold)">{{ $naoCompareceram }}</div><div class="metric-desc">Esse mês</div></div>
    </div>
    <div class="card">
      <div class="card-header"><div><div class="card-title">Faturamento — Últimos <span style="color:var(--gold-light)">6 Meses</span></div><div class="card-sub">// R$ por mês</div></div></div>
      @php $maxFat = collect($meses)->max('faturamento') ?: 1; @endphp
      <div class="bar-chart">
        @foreach($meses as $m)
        <div class="bar-group">
          <span style="font-size:10px;color:var(--gold-light)">R${{ number_format($m['faturamento'], 0, ',', '.') }}</span>
          <div class="bar" style="height:{{ ($m['faturamento'] / $maxFat) * 100 }}%"></div>
          <span class="bar-label">{{ $m['mes'] }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</main>
</body></html>