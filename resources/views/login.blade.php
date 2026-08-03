<!DOCTYPE html>
<html lang="pt-BR" style="color-scheme:dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="color-scheme" content="dark"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
  <title>Login — StudioPro</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html,body{background:#000000!important;color-scheme:dark;min-height:100vh}
    body{color:#F8FAFC;font-family:'Inter',sans-serif;font-size:14px;line-height:1.6;display:flex;flex-direction:column;min-height:100vh}
    ::-webkit-scrollbar{width:3px}::-webkit-scrollbar-thumb{background:#DC2626}

    .glitch{position:relative;display:inline-block;font-family:'Bebas Neue',sans-serif}
    .glitch::before,.glitch::after{content:attr(data-text);position:absolute;top:0;left:0;width:100%;height:100%;font-family:'Bebas Neue',sans-serif;font-size:inherit;font-weight:inherit}
    .glitch::before{color:#3B82F6;clip-path:polygon(0 0,100% 0,100% 35%,0 35%);animation:glitch1 2.5s infinite}
    .glitch::after{color:#DC2626;clip-path:polygon(0 65%,100% 65%,100% 100%,0 100%);animation:glitch2 2.5s infinite;opacity:.7}
    @keyframes glitch1{0%,85%,100%{transform:translateX(0);opacity:0}87%{transform:translateX(-4px);opacity:.9}92%{transform:translateX(2px);opacity:.6}}
    @keyframes glitch2{0%,85%,100%{transform:translateX(0);opacity:0}88%{transform:translateX(4px);opacity:.8}93%{transform:translateX(-2px);opacity:.5}}

    .page{flex:1;display:flex;align-items:center;justify-content:center;padding:24px;position:relative;overflow:hidden}
    .page::before{content:'';position:absolute;top:-200px;right:-200px;width:500px;height:500px;background:radial-gradient(circle,rgba(220,38,38,.06) 0%,transparent 65%);border-radius:50%;pointer-events:none}
    .page::after{content:'';position:absolute;bottom:-200px;left:-200px;width:500px;height:500px;background:radial-gradient(circle,rgba(29,78,216,.06) 0%,transparent 65%);border-radius:50%;pointer-events:none}

    .login-card{background:#0f0f0f;border:1px solid #1a1a1a;border-radius:8px;padding:40px;width:100%;max-width:420px;position:relative;z-index:1}
    .login-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#DC2626,#1D4ED8);border-radius:8px 8px 0 0}

    .logo{font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:3px;color:#fff;text-align:center;margin-bottom:8px;text-decoration:none;display:block}
    .logo span{color:#DC2626}
    .login-title{font-family:'Bebas Neue',sans-serif;font-size:32px;letter-spacing:2px;color:#fff;text-align:center;margin-bottom:4px}
    .login-sub{font-size:12px;color:#6B7280;text-align:center;margin-bottom:32px}

    .form-group{margin-bottom:18px}
    .form-label{font-size:11px;font-weight:600;color:#6B7280;letter-spacing:1px;text-transform:uppercase;margin-bottom:6px;display:block}
    .form-input{width:100%;background:#000000!important;border:1px solid #1a1a1a;color:#F8FAFC!important;padding:12px 14px;border-radius:6px;font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s;color-scheme:dark;-webkit-appearance:none;appearance:none}
    .form-input:focus{border-color:#1D4ED8}
    .form-input::placeholder{color:#4B5563}

    .forgot{display:block;text-align:right;font-size:12px;color:#6B7280;text-decoration:none;margin-top:-10px;margin-bottom:20px;transition:color .2s}
    .forgot:hover{color:#3B82F6}

    .btn-login{width:100%;background:#1D4ED8;color:#fff;border:1px solid #1D4ED8;padding:13px;font-size:13px;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;border-radius:6px;box-shadow:0 4px 15px rgba(29,78,216,.35);position:relative;overflow:hidden;transition:all .2s ease-in;letter-spacing:.5px;margin-bottom:16px}
    .btn-login::before{content:'';display:block;width:0;height:86%;position:absolute;top:7%;left:0;opacity:0;background:#fff;box-shadow:0 0 50px 30px #fff;transform:skewX(-20deg)}
    .btn-login:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(29,78,216,.55)}
    .btn-login:hover::before{animation:sh02 .5s linear}
    @keyframes sh02{from{opacity:0;left:0%}50%{opacity:1}to{opacity:0;left:100%}}

    .divider{display:flex;align-items:center;gap:12px;margin-bottom:16px}
    .divider::before,.divider::after{content:'';flex:1;height:1px;background:#1a1a1a}
    .divider span{font-size:11px;color:#4B5563;text-transform:uppercase;letter-spacing:1px}

    .btn-google{width:100%;background:transparent;color:#F8FAFC;border:1px solid #1a1a1a;padding:12px;font-size:13px;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;border-radius:6px;display:flex;align-items:center;justify-content:center;gap:10px;transition:all .2s;margin-bottom:24px}
    .btn-google:hover{border-color:#3B82F6;background:rgba(29,78,216,.05)}

    .back-link{display:block;text-align:center;font-size:12px;color:#6B7280;text-decoration:none;transition:color .2s}
    .back-link:hover{color:#fff}
    .back-link span{color:#DC2626}

    .error-msg{background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.3);color:#FCA5A5;padding:10px 14px;border-radius:6px;font-size:12px;margin-bottom:16px;display:none}

    footer{padding:20px;text-align:center}
    footer p{font-size:11px;color:#374151}
    footer a{color:#4B5563;text-decoration:none}
    footer a:hover{color:#6B7280}
  </style>
</head>
<body>

<div class="page">
  <div class="login-card">
    <a href="/" class="logo">BARBER<span>PRO</span></a>
    <h1 class="login-title"><span class="glitch" data-text="ACESSO">ACES<span style="color:#3B82F6">SO</span></span></h1>
    <p class="login-sub">// Painel administrativo da barbearia</p>

    @if(session('error'))
    <div class="error-msg" style="display:block">{{ session('error') }}</div>
    @endif

    @if($errors->any())
    <div class="error-msg" style="display:block">
      @foreach($errors->all() as $error)
        {{ $error }}<br>
      @endforeach
    </div>
    @endif

    <form method="POST" action="/login">
      @csrf
      <div class="form-group">
        <label class="form-label">E-mail</label>
        <input class="form-input" type="email" name="email" placeholder="admin@suabarbearia.com" value="{{ old('email') }}" required autofocus/>
      </div>
      <div class="form-group">
        <label class="form-label">Senha</label>
        <input class="form-input" type="password" name="password" placeholder="••••••••" required/>
      </div>
      <a href="/esqueci-senha" class="forgot">Esqueci minha senha</a>
      <button type="submit" class="btn-login">Entrar no Painel</button>
    </form>

    <div class="divider"><span>ou</span></div>

    <a href="/auth/google" class="btn-google">
      <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
      Entrar com Google
    </a>

    <a href="/" class="back-link">← Voltar para <span>studiopro.tech</span></a>
  </div>
</div>

<footer>
  <p><a href="/termos">Termos de Uso</a> · <a href="/privacidade">Privacidade</a> · © 2026 StudioPro</p>
</footer>

<script>
document.addEventListener('gesturestart', function(e) { e.preventDefault(); });
document.addEventListener('touchmove', function(e) { if(e.scale !== 1) e.preventDefault(); }, { passive: false });
</script>
</body>
</html>