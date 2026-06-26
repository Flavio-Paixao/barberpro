<!DOCTYPE html>
<html lang="pt-BR" style="color-scheme:dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="color-scheme" content="dark"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BarberPro — Agendar</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --bg:#000000;
      --surface:#0f0f0f;
      --border:#1a1a1a;
      --red:#DC2626;
      --red-light:#EF4444;
      --blue:#1D4ED8;
      --blue-light:#3B82F6;
      --white:#FFFFFF;
      --text:#F8FAFC;
      --muted:#6B7280;
      --green:#22c55e;
    }
    html,body{background:#000000!important;color-scheme:dark;min-height:100vh}
    body{color:var(--text);font-family:'Inter',sans-serif;font-size:14px;line-height:1.6;overflow-x:hidden}
    ::-webkit-scrollbar{width:3px}::-webkit-scrollbar-thumb{background:var(--red)}

    /* GLITCH */
    .glitch{position:relative;display:inline-block;font-family:'Bebas Neue',sans-serif}
    .glitch::before,.glitch::after{content:attr(data-text);position:absolute;top:0;left:0;width:100%;height:100%;font-family:'Bebas Neue',sans-serif;font-size:inherit;font-weight:inherit}
    .glitch::before{color:var(--blue-light);clip-path:polygon(0 0,100% 0,100% 35%,0 35%);animation:glitch1 2.5s infinite}
    .glitch::after{color:var(--red);clip-path:polygon(0 65%,100% 65%,100% 100%,0 100%);animation:glitch2 2.5s infinite;opacity:.7}
    @keyframes glitch1{0%,85%,100%{transform:translateX(0);opacity:0}87%{transform:translateX(-4px);opacity:.9}92%{transform:translateX(2px);opacity:.6}}
    @keyframes glitch2{0%,85%,100%{transform:translateX(0);opacity:0}88%{transform:translateX(4px);opacity:.8}93%{transform:translateX(-2px);opacity:.5}}

    /* BUTTONS */
    .btn{position:relative;overflow:hidden;border-radius:6px;font-family:'Inter',sans-serif;font-size:13px;font-weight:700;letter-spacing:.5px;padding:12px 24px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .2s ease-in;border:none;box-shadow:0 4px 15px rgba(0,0,0,0.5),inset 0 1px 0 rgba(255,255,255,0.08)}
    .btn::before{content:'';display:block;width:0;height:86%;position:absolute;top:7%;left:0;opacity:0;background:#fff;box-shadow:0 0 50px 30px #fff;transform:skewX(-20deg)}
    .btn:hover{transform:translateY(-2px)}
    .btn:hover::before{animation:sh02 .5s linear}
    .btn:active{transform:translateY(0)!important}
    @keyframes sh02{from{opacity:0;left:0%}50%{opacity:1}to{opacity:0;left:100%}}
    .btn-red{background:var(--red);color:var(--white);border:1px solid var(--red)}
    .btn-red:hover{box-shadow:0 8px 25px rgba(220,38,38,.6);transition:all .2s ease-out}
    .btn-outline-red{background:transparent;color:var(--red);border:1px solid var(--red)}
    .btn-outline-red:hover{background:var(--red);color:var(--white);box-shadow:0 8px 25px rgba(220,38,38,.5);transition:all .2s ease-out}
    .btn-green{background:var(--green);color:#000;border:1px solid var(--green)}
    .btn-green:hover{box-shadow:0 8px 25px rgba(34,197,94,.5);transition:all .2s ease-out}

    /* LAYOUT */
    .container{max-width:1200px;margin:0 auto;padding:0 24px}
    .divider{height:1px;background:var(--border)}
    section{padding:80px 0;position:relative;z-index:1}

    /* NAV */
    nav{position:sticky;top:0;z-index:100;border-bottom:1px solid var(--border);background:rgba(0,0,0,.97);backdrop-filter:blur(20px);padding:16px 0}
    .nav-inner{display:flex;align-items:center;justify-content:space-between;gap:16px}
    .nav-logo{font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:3px}
    .nav-logo .pro{color:var(--red)}
    .nav-links{display:flex;gap:32px;list-style:none}
    .nav-links a{font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:var(--muted);text-decoration:none;transition:color .2s}
    .nav-links a:hover{color:var(--white)}

    /* HERO */
    .hero{padding:80px 0 60px;position:relative;overflow:hidden}
    .hero::before{content:'';position:absolute;top:-200px;right:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(220,38,38,.08) 0%,transparent 65%);border-radius:50%;pointer-events:none}
    .hero::after{content:'';position:absolute;bottom:-150px;left:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(29,78,216,.06) 0%,transparent 65%);border-radius:50%;pointer-events:none}
    .hero-inner{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;position:relative;z-index:1}
    .hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.3);color:var(--red);padding:6px 14px;border-radius:20px;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:20px}
    .badge-dot{width:6px;height:6px;background:var(--red);border-radius:50%;animation:pulse 2s infinite}
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.3)}}
    .hero h1{font-family:'Bebas Neue',sans-serif;font-size:clamp(56px,8vw,88px);line-height:.95;letter-spacing:3px;margin-bottom:20px}
    .hero-desc{font-size:15px;color:var(--muted);line-height:1.7;margin-bottom:32px;max-width:440px}
    .hero-btns{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:40px}
    .hero-stats{display:flex;gap:32px}
    .stat-num{font-family:'Bebas Neue',sans-serif;font-size:34px;letter-spacing:2px;color:var(--white);line-height:1}
    .stat-num .accent{color:var(--red)}
    .stat-label{font-size:11px;color:var(--muted);letter-spacing:1px;text-transform:uppercase;margin-top:4px}

    /* BOOKING CARD */
    .booking-card{background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:32px;position:relative;overflow:hidden}
    .booking-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--red),var(--blue))}
    .booking-title{font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:2px;color:var(--white);margin-bottom:4px}
    .booking-sub{font-size:12px;color:var(--muted);margin-bottom:24px}
    .form-group{margin-bottom:16px}
    .form-label{font-size:11px;font-weight:600;color:var(--muted);letter-spacing:1px;text-transform:uppercase;margin-bottom:6px;display:block}
    .form-input,.form-select{width:100%;background:#000000!important;border:1px solid var(--border);color:var(--text)!important;padding:11px 14px;border-radius:6px;font-size:13px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s;color-scheme:dark;-webkit-appearance:none;appearance:none}
    .form-input:focus,.form-select:focus{border-color:var(--red)}
    .form-select option{background:#000000}
    .time-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:6px}
    .time-slot{background:#000000;border:1px solid var(--border);color:var(--muted);padding:9px;font-size:12px;font-weight:600;text-align:center;cursor:pointer;transition:all .2s;border-radius:6px}
    .time-slot:hover,.time-slot.active{background:rgba(220,38,38,.1);border-color:var(--red);color:var(--red)}
    .time-slot.taken{opacity:.3;cursor:not-allowed;pointer-events:none}
    .time-loading{font-size:12px;color:var(--muted);padding:16px;text-align:center}
    .btn-book{width:100%;background:var(--red);color:var(--white);border:1px solid var(--red);padding:14px;font-size:13px;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s ease-in;margin-top:12px;border-radius:6px;box-shadow:0 4px 15px rgba(220,38,38,.35);position:relative;overflow:hidden}
    .btn-book::before{content:'';display:block;width:0;height:86%;position:absolute;top:7%;left:0;opacity:0;background:#fff;box-shadow:0 0 50px 30px #fff;transform:skewX(-20deg)}
    .btn-book:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(220,38,38,.55)}
    .btn-book:hover::before{animation:sh02 .5s linear}
    .btn-book:disabled{opacity:.5;cursor:not-allowed;transform:none}
    .wpp-note{display:flex;align-items:center;gap:8px;background:rgba(34,197,94,.06);border:1px solid rgba(34,197,94,.2);border-radius:6px;padding:10px 14px;margin-top:12px}
    .wpp-note span{font-size:11px;color:var(--green)}
    .success-card{display:none;background:rgba(34,197,94,.06);border:1px solid var(--green);padding:32px;text-align:center;border-radius:8px}
    .success-icon{width:56px;height:56px;background:rgba(34,197,94,.1);border:1px solid var(--green);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:var(--green);border-radius:50%}
    .success-title{font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:2px;color:var(--green);margin-bottom:8px}
    .success-desc{font-size:13px;color:var(--muted);line-height:1.7;margin-bottom:20px}

    /* SERVICES */
    .services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
    .service-card{background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:24px;transition:all .2s;position:relative;overflow:hidden}
    .service-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--red),var(--blue));transform:scaleX(0);transition:transform .3s;transform-origin:left}
    .service-card:hover{border-color:var(--red);transform:translateY(-4px)}
    .service-card:hover::after{transform:scaleX(1)}
    .service-icon{width:44px;height:44px;background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;color:var(--red)}
    .service-name{font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:1px;color:var(--white);margin-bottom:8px}
    .service-desc{font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:16px}
    .service-footer{display:flex;align-items:center;justify-content:space-between}
    .service-price{font-family:'Bebas Neue',sans-serif;font-size:26px;letter-spacing:1px;color:var(--red)}
    .service-time{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:4px}

    /* BARBERS */
    .barbers-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .barber-card{background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:24px;text-align:center;transition:all .2s}
    .barber-card:hover{border-color:var(--red);transform:translateY(-4px)}
    .barber-avatar{width:72px;height:72px;background:linear-gradient(135deg,var(--red),var(--blue));border-radius:50%;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:26px;letter-spacing:1px;color:var(--white)}
    .barber-name{font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:1px;color:var(--white);margin-bottom:4px}
    .barber-spec{font-size:12px;color:var(--red);font-weight:600;letter-spacing:1px;text-transform:uppercase;margin-bottom:12px}
    .barber-stars{display:flex;align-items:center;justify-content:center;gap:2px;color:var(--red);margin-bottom:12px;font-size:14px}
    .barber-tags{display:flex;flex-wrap:wrap;gap:6px;justify-content:center}
    .barber-tag{font-size:11px;background:rgba(29,78,216,.1);border:1px solid rgba(29,78,216,.2);color:var(--blue-light);padding:3px 10px;border-radius:20px}

    /* HOW */
    .steps-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px}
    .step{text-align:center;position:relative}
    .step:not(:last-child)::after{content:'';position:absolute;top:28px;left:calc(50% + 28px);right:calc(-50% + 28px);height:1px;background:var(--border)}
    .step-num{width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:1px;position:relative;z-index:1}
    .step-num.red{background:var(--red);color:var(--white)}
    .step-num.blue{background:var(--blue);color:var(--white)}
    .step-title{font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1px;color:var(--white);margin-bottom:8px}
    .step-desc{font-size:12px;color:var(--muted);line-height:1.6}

    .sec-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.3);color:var(--red);padding:5px 14px;border-radius:20px;font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;margin-bottom:16px}
    .sec-title{font-family:'Bebas Neue',sans-serif;font-size:clamp(36px,5vw,56px);letter-spacing:3px;color:var(--white);margin-bottom:12px}
    .sec-title span{color:var(--red)}
    .sec-sub{font-size:15px;color:var(--muted);max-width:480px;margin:0 auto}

    footer{padding:40px 0;border-top:1px solid var(--border)}
    .footer-inner{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px}
    .footer-logo{font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:3px;color:var(--white)}
    .footer-logo .pro{color:var(--red)}
    .footer-link{font-size:11px;color:var(--muted);text-decoration:none;letter-spacing:1px;text-transform:uppercase;transition:color .2s}
    .footer-link:hover{color:var(--red)}


    @media(max-width:1024px){.services-grid,.barbers-grid{grid-template-columns:repeat(2,1fr)}.steps-grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:768px){.hero-inner{grid-template-columns:1fr}.services-grid,.barbers-grid,.steps-grid{grid-template-columns:1fr}.nav-links{display:none}.time-grid{grid-template-columns:repeat(3,1fr)}}
  </style>
</head>
<body>

<nav>
  <div class="container">
    <div class="nav-inner">
      <span class="nav-logo">BARBER<span class="pro">PRO</span></span>
      <ul class="nav-links">
        <li><a href="#servicos">Serviços</a></li>
        <li><a href="#barbeiros">Barbeiros</a></li>
        <li><a href="#como-funciona">Como Funciona</a></li>
      </ul>
      <a href="https://wa.me/5511999999999" target="_blank" class="btn btn-green" style="padding:9px 18px;font-size:12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
        WhatsApp
      </a>
    </div>
  </div>
</nav>

<section class="hero" id="agendar">
  <div class="container">
    <div class="hero-inner">
      <div>
        <div class="hero-badge"><div class="badge-dot"></div> Agendamento Online 24h</div>
        <h1>
          <span class="glitch" data-text="AGENDE" style="color:var(--white)">AGENDE</span><br>
          <span class="glitch" data-text="SEU CORTE" style="color:var(--blue-light)">SEU CORTE</span><br>
          <span class="glitch" data-text="ONLINE" style="color:var(--white)">ONLINE</span>
        </h1>
        <p class="hero-desc">Sem espera, sem ligação. Escolha seu barbeiro favorito, o horário ideal e receba confirmação instantânea no WhatsApp.</p>
        <div class="hero-btns">
          <a href="#agendar" class="btn btn-red">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Agendar Agora
          </a>
          <a href="#servicos" class="btn btn-outline-red">Ver Serviços</a>
        </div>
        <div class="hero-stats">
          <div>
            <div class="stat-num">500<span class="accent">+</span></div>
            <div class="stat-label">Clientes</div>
          </div>
          <div>
            <div class="stat-num">4.9<span class="accent">★</span></div>
            <div class="stat-label">Avaliação</div>
          </div>
          <div>
            <div class="stat-num">3<span class="accent">+</span></div>
            <div class="stat-label">Barbeiros</div>
          </div>
        </div>
      </div>

      <div>
        <div class="booking-card" id="bookingForm">
          <div class="booking-title">NOVO AGENDAMENTO</div>
          <div class="booking-sub">Preencha os dados e confirme pelo WhatsApp</div>
          <div class="form-group">
            <label class="form-label">Seu Nome</label>
            <input class="form-input" type="text" id="clienteNome" placeholder="Ex: João Silva"/>
          </div>
          <div class="form-group">
            <label class="form-label">WhatsApp</label>
            <input class="form-input" type="tel" id="clienteTelefone" placeholder="(11) 99999-9999"/>
          </div>
          <div class="form-group">
            <label class="form-label">Barbeiro</label>
            <select class="form-select" id="barbeiroId" onchange="carregarHorarios()">
              <option value="">Selecione o barbeiro</option>
              @foreach($barbeiros as $barbeiro)
                <option value="{{ $barbeiro->id }}">{{ $barbeiro->nome }}{{ $barbeiro->especialidade ? ' — ' . $barbeiro->especialidade : '' }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Serviço</label>
            <select class="form-select" id="servicoId" onchange="carregarHorarios()">
              <option value="">Selecione o serviço</option>
              @foreach($servicos as $servico)
                <option value="{{ $servico->id }}">{{ $servico->nome }} — R${{ number_format($servico->preco, 2, ',', '.') }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Data</label>
            <input class="form-input" type="date" id="data" onchange="carregarHorarios()" min="{{ date('Y-m-d') }}"/>
          </div>
          <div class="form-group">
            <label class="form-label">Horário Disponível</label>
            <div id="timeGrid" class="time-grid">
              <div class="time-loading">Selecione barbeiro, serviço e data</div>
            </div>
            <input type="hidden" id="horarioSelecionado"/>
          </div>
          <button class="btn-book" id="btnAgendar" onclick="confirmarAgendamento()" disabled>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Confirmar Agendamento
          </button>
          <div class="wpp-note">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="#22c55e"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            <span>Confirmação enviada automaticamente pelo WhatsApp</span>
          </div>
        </div>
        <div class="success-card" id="successCard">
          <div class="success-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="success-title">AGENDAMENTO CONFIRMADO!</div>
          <div class="success-desc" id="successDesc">Você receberá uma confirmação no WhatsApp em breve.</div>
          <button onclick="voltarInicio()" class="btn btn-red" style="margin:0 auto">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Novo Agendamento
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="divider"></div>

<section id="servicos">
  <div class="container">
    <div style="text-align:center;margin-bottom:48px">
      <div class="sec-badge">Nossos Serviços</div>
      <h2 class="sec-title">O QUE <span>OFERECEMOS</span></h2>
      <p class="sec-sub">Serviços premium para o homem moderno</p>
    </div>
    <div class="services-grid">
      <div class="service-card">
        <div class="service-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/></svg>
        </div>
        <div class="service-name">CORTE MASCULINO</div>
        <div class="service-desc">Corte tradicional ou moderno com acabamento perfeito e finalização profissional.</div>
        <div class="service-footer">
          <div class="service-price">R$45</div>
          <div class="service-time"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 30 min</div>
        </div>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div class="service-name">BARBA COMPLETA</div>
        <div class="service-desc">Aparagem, modelagem e hidratação da barba com produtos premium importados.</div>
        <div class="service-footer">
          <div class="service-price">R$35</div>
          <div class="service-time"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 25 min</div>
        </div>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="service-name">CORTE + BARBA</div>
        <div class="service-desc">Combo completo com corte, barba e hidratação. O melhor custo-benefício da casa.</div>
        <div class="service-footer">
          <div class="service-price">R$70</div>
          <div class="service-time"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 50 min</div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="divider"></div>

<section id="barbeiros" style="background:var(--surface)">
  <div class="container">
    <div style="text-align:center;margin-bottom:48px">
      <div class="sec-badge">Nossa Equipe</div>
      <h2 class="sec-title">NOSSOS <span>BARBEIROS</span></h2>
    </div>
    <div class="barbers-grid">
      <div class="barber-card">
        <div class="barber-avatar">CA</div>
        <div class="barber-name">CARLOS ANDRADE</div>
        <div class="barber-spec">Especialista em Degradê</div>
        <div class="barber-stars">★★★★★ <span style="font-size:11px;color:var(--muted);margin-left:4px">4.9 (127)</span></div>
        <div class="barber-tags"><span class="barber-tag">Degradê</span><span class="barber-tag">Moderno</span><span class="barber-tag">Navalhado</span></div>
      </div>
      <div class="barber-card">
        <div class="barber-avatar">LM</div>
        <div class="barber-name">LUCAS MARTINS</div>
        <div class="barber-spec">Barba & Corte Clássico</div>
        <div class="barber-stars">★★★★★ <span style="font-size:11px;color:var(--muted);margin-left:4px">4.8 (98)</span></div>
        <div class="barber-tags"><span class="barber-tag">Barba</span><span class="barber-tag">Clássico</span><span class="barber-tag">Relaxamento</span></div>
      </div>
      <div class="barber-card">
        <div class="barber-avatar">RS</div>
        <div class="barber-name">RAFAEL SILVA</div>
        <div class="barber-spec">Cortes Modernos</div>
        <div class="barber-stars">★★★★★ <span style="font-size:11px;color:var(--muted);margin-left:4px">4.9 (143)</span></div>
        <div class="barber-tags"><span class="barber-tag">Undercut</span><span class="barber-tag">Texturizado</span><span class="barber-tag">Moderno</span></div>
      </div>
    </div>
  </div>
</section>

<div class="divider"></div>

<section id="como-funciona">
  <div class="container">
    <div style="text-align:center;margin-bottom:48px">
      <div class="sec-badge">Como Funciona</div>
      <h2 class="sec-title">4 PASSOS <span>SIMPLES</span></h2>
    </div>
    <div class="steps-grid">
      <div class="step">
        <div class="step-num red">1</div>
        <div class="step-title">ESCOLHA O BARBEIRO</div>
        <div class="step-desc">Selecione seu barbeiro favorito e o serviço desejado.</div>
      </div>
      <div class="step">
        <div class="step-num blue">2</div>
        <div class="step-title">SELECIONE O HORÁRIO</div>
        <div class="step-desc">Veja os horários disponíveis e escolha o melhor.</div>
      </div>
      <div class="step">
        <div class="step-num red">3</div>
        <div class="step-title">CONFIRME PELO WHATSAPP</div>
        <div class="step-desc">Receba a confirmação instantânea no WhatsApp.</div>
      </div>
      <div class="step">
        <div class="step-num blue">4</div>
        <div class="step-title">APAREÇA NO HORÁRIO</div>
        <div class="step-desc">Chegue na hora marcada e seja atendido sem espera.</div>
      </div>
    </div>
  </div>
</section>

<section style="background:var(--surface);text-align:center;padding:80px 0;border-top:1px solid var(--border)">
  <div class="container">
    <div class="sec-badge" style="margin-bottom:16px">Agende Agora</div>
    <h2 class="sec-title" style="margin-bottom:12px">PRONTO PARA <span>AGENDAR?</span></h2>
    <p style="color:var(--muted);font-size:15px;margin-bottom:36px">Sem complicação, sem espera. Seu horário em menos de 1 minuto.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a href="#agendar" class="btn btn-red">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Agendar Agora
      </a>
      <a href="https://wa.me/5511999999999" class="btn btn-green">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
        WhatsApp
      </a>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="footer-inner">
      <span class="footer-logo">BARBER<span class="pro">PRO</span></span>
      <span style="font-size:11px;color:var(--muted)">Desenvolvido por <a href="http://portfolio-php-681892816208.s3-website-sa-east-1.amazonaws.com/" target="_blank" style="color:var(--blue-light);text-decoration:none">Flávio Paixão</a></span>
      <div style="display:flex;gap:20px">
        <a href="/termos" class="footer-link">Termos de Uso</a>
        <a href="/privacidade" class="footer-link">Privacidade</a>
      </div>
    </div>
  </div>
</footer>

<script>
  let horarioSelecionado = null;

  async function carregarHorarios() {
    const barbeiroId = document.getElementById('barbeiroId').value;
    const servicoId = document.getElementById('servicoId').value;
    const data = document.getElementById('data').value;
    const grid = document.getElementById('timeGrid');

    if (!barbeiroId || !servicoId || !data) {
      grid.innerHTML = '<div class="time-loading">Selecione barbeiro, serviço e data</div>';
      return;
    }

    grid.innerHTML = '<div class="time-loading">Carregando horários...</div>';

    try {
      const res = await fetch(`/horarios-disponiveis?barbeiro_id=${barbeiroId}&servico_id=${servicoId}&data=${data}`);
      const horarios = await res.json();

      if (horarios.length === 0) {
        grid.innerHTML = '<div class="time-loading">Nenhum horário disponível</div>';
        return;
      }

      grid.innerHTML = horarios.map(h => `
        <div class="time-slot ${!h.disponivel ? 'taken' : ''}"
             onclick="${h.disponivel ? `selecionarHorario('${h.horario}', this)` : ''}">
          ${h.horario}
        </div>
      `).join('');
    } catch (e) {
      grid.innerHTML = '<div class="time-loading">Erro ao carregar horários</div>';
    }
  }

  function selecionarHorario(horario, el) {
    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('active'));
    el.classList.add('active');
    horarioSelecionado = horario;
    document.getElementById('horarioSelecionado').value = horario;
    document.getElementById('btnAgendar').disabled = false;
  }

  async function confirmarAgendamento() {
    const nome = document.getElementById('clienteNome').value.trim();
    const tel = document.getElementById('clienteTelefone').value.trim();
    const barbeiroId = document.getElementById('barbeiroId').value;
    const servicoId = document.getElementById('servicoId').value;
    const data = document.getElementById('data').value;

    if (!nome || !tel || !barbeiroId || !servicoId || !data || !horarioSelecionado) {
      alert('Preencha todos os campos!');
      return;
    }

    const btn = document.getElementById('btnAgendar');
    btn.disabled = true;
    btn.textContent = 'Aguarde...';

    try {
      const res = await fetch('/agendar', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
          cliente_nome: nome,
          cliente_telefone: tel,
          barbeiro_id: barbeiroId,
          servico_id: servicoId,
          data: data,
          horario: horarioSelecionado,
        }),
      });

      const result = await res.json();

if (result.sucesso) {
    document.getElementById('bookingForm').style.display = 'none';
    document.getElementById('successCard').style.display = 'block';
    document.getElementById('successDesc').innerHTML = `Olá <strong>${nome}</strong>!<br><br>Agendamento confirmado.<br>Você receberá uma confirmação no WhatsApp em breve.<br><br><strong>Data:</strong> ${data}<br><strong>Horário:</strong> ${horarioSelecionado}`;
    // Limpa os campos para próximo agendamento
    document.getElementById('clienteNome').value = '';
    document.getElementById('clienteTelefone').value = '';
    document.getElementById('barbeiroId').value = '';
    document.getElementById('servicoId').value = '';
    document.getElementById('data').value = '';
    document.getElementById('timeGrid').innerHTML = '<div class="time-loading">Selecione barbeiro, serviço e data</div>';
    horarioSelecionado = null;
    document.getElementById('btnAgendar').disabled = true;
    btn.textContent = 'Confirmar Agendamento';
} else {
        alert('Erro ao agendar. Tente novamente.');
        btn.disabled = false;
        btn.textContent = 'Confirmar Agendamento';
      }
    } catch (e) {
      alert('Erro ao agendar. Tente novamente.');
      btn.disabled = false;
      btn.textContent = 'Confirmar Agendamento';
    }
  }

function voltarInicio() {
    document.getElementById('successCard').style.display = 'none';
    document.getElementById('bookingForm').style.display = 'block';
    document.getElementById('clienteNome').value = '';
    document.getElementById('clienteTelefone').value = '';
    document.getElementById('barbeiroId').value = '';
    document.getElementById('servicoId').value = '';
    document.getElementById('data').value = '';
    document.getElementById('timeGrid').innerHTML = '<div class="time-loading">Selecione barbeiro, serviço e data</div>';
    horarioSelecionado = null;
    document.getElementById('btnAgendar').disabled = true;
}
</script>

<script>
document.addEventListener('gesturestart', function(e) { e.preventDefault(); });
document.addEventListener('touchmove', function(e) { if(e.scale !== 1) e.preventDefault(); }, { passive: false });
</script>
</body>
</html>
