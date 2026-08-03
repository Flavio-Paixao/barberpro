<!DOCTYPE html>
<html lang="pt-BR" style="color-scheme:dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="color-scheme" content="dark"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
  <title>Super Admin — StudioPro</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html,body{background:#000000!important;color-scheme:dark;min-height:100vh}
    body{color:#F8FAFC;font-family:'Inter',sans-serif;font-size:14px;line-height:1.6;display:flex;flex-direction:column;min-height:100vh}
    ::-webkit-scrollbar{width:3px}::-webkit-scrollbar-thumb{background:#DC2626}

    .glitch{position:relative;display:inline-block;font-family:'Bebas Neue',sans-serif}
    .glitch::before,.glitch::after{content:attr(data-text);position:absolute;top:0;left:0;width:100%;height:100%;font-family:'Bebas Neue',sans-serif;font-size:inherit}
    .glitch::before{color:#DC2626;clip-path:polygon(0 0,100% 0,100% 35%,0 35%);animation:glitch1 2.5s infinite}
    .glitch::after{color:#3B82F6;clip-path:polygon(0 65%,100% 65%,100% 100%,0 100%);animation:glitch2 2.5s infinite;opacity:.7}
    @keyframes glitch1{0%,85%,100%{transform:translateX(0);opacity:0}87%{transform:translateX(-4px);opacity:.9}92%{transform:translateX(2px);opacity:.6}}
    @keyframes glitch2{0%,85%,100%{transform:translateX(0);opacity:0}88%{transform:translateX(4px);opacity:.8}93%{transform:translateX(-2px);opacity:.5}}

    /* TERMINAL BACKGROUND PATTERN */
    .page{flex:1;display:flex;align-items:center;justify-content:center;padding:24px;position:relative;overflow:hidden;background:
      linear-gradient(rgba(220,38,38,.025) 1px,transparent 1px),
      linear-gradient(90deg,rgba(220,38,38,.025) 1px,transparent 1px);
      background-size:40px 40px;
    }
    .page::before{content:'';position:absolute;top:-300px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(circle,rgba(220,38,38,.08) 0%,transparent 65%);pointer-events:none}

    .terminal-tag{position:absolute;top:24px;left:24px;font-family:'Space Mono',monospace;font-size:11px;color:#374151;display:flex;align-items:center;gap:8px}
    .terminal-dots{display:flex;gap:5px}
    .terminal-dots span{width:8px;height:8px;border-radius:50%}
    .terminal-dots span:nth-child(1){background:#DC2626}
    .terminal-dots span:nth-child(2){background:#eab308}
    .terminal-dots span:nth-child(3){background:#22c55e}

    .login-card{background:#0a0a0a;border:1px solid #1a1a1a;border-radius:8px;padding:44px 40px;width:100%;max-width:440px;position:relative;z-index:1;box-shadow:0 20px 60px rgba(0,0,0,.5)}
    .login-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#DC2626,#000,#DC2626);border-radius:8px 8px 0 0}

    .access-badge{display:flex;align-items:center;justify-content:center;gap:8px;background:rgba(220,38,38,.08);border:1px solid rgba(220,38,38,.25);color:#DC2626;padding:8px;border-radius:6px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:28px;font-family:'Space Mono',monospace}
    .access-badge svg{flex-shrink:0}

    .logo{font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:3px;color:#fff;text-align:center;margin-bottom:4px;text-decoration:none;display:block}
    .logo span{color:#DC2626}
    .login-title{font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:2px;color:#fff;text-align:center;margin-bottom:6px}
    .login-sub{font-size:11px;color:#4B5563;text-align:center;margin-bottom:36px;font-family:'Space Mono',monospace}

    .form-group{margin-bottom:18px}
    .form-label{font-size:10px;font-weight:700;color:#4B5563;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:7px;display:flex;align-items:center;gap:6px;font-family:'Space Mono',monospace}
    .form-input{width:100%;background:#000000!important;border:1px solid #1f1f1f;color:#F8FAFC!important;padding:13px 14px;border-radius:6px;font-size:14px;font-family:'Space Mono',monospace;outline:none;transition:all .2s;color-scheme:dark;-webkit-appearance:none;appearance:none}
    .form-input:focus{border-color:#DC2626;box-shadow:0 0 0 3px rgba(220,38,38,.1)}
    .form-input::placeholder{color:#374151}

    .btn-login{width:100%;background:#000;color:#fff;border:1px solid #DC2626;padding:14px;font-size:12px;font-weight:700;font-family:'Space Mono',monospace;cursor:pointer;border-radius:6px;position:relative;overflow:hidden;transition:all .2s;letter-spacing:2px;text-transform:uppercase;margin-top:8px}
    .btn-login::before{content:'';display:block;width:0;height:86%;position:absolute;top:7%;left:0;opacity:0;background:#DC2626;box-shadow:0 0 50px 30px #DC2626;transform:skewX(-20deg)}
    .btn-login:hover{background:#DC2626;box-shadow:0 8px 25px rgba(220,38,38,.4)}
    .btn-login:hover::before{animation:sh02 .5s linear}
    @keyframes sh02{from{opacity:0;left:0%}50%{opacity:.3}to{opacity:0;left:100%}}

    .error-msg{background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.3);color:#FCA5A5;padding:10px 14px;border-radius:6px;font-size:12px;margin-bottom:16px;font-family:'Space Mono',monospace}

    .back-link{display:block;text-align:center;font-size:11px;color:#374151;text-decoration:none;margin-top:28px;font-family:'Space Mono',monospace;transition:color .2s}
    .back-link:hover{color:#6B7280}

    footer{padding:20px;text-align:center}
    footer p{font-size:10px;color:#1f2937;font-family:'Space Mono',monospace}
  </style>
</head>
<body>

<div class="page">
  <div class="terminal-tag">
    <div class="terminal-dots"><span></span><span></span><span></span></div>
    root@studiopro:~#
  </div>

  <div class="login-card">
    <div class="access-badge">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      Acesso Restrito
    </div>

    <a href="/" class="logo">STUDIO<span>PRO</span></a>
    <h1 class="login-title"><span class="glitch" data-text="ROOT">RO<span style="color:#DC2626">OT</span></span></h1>
    <p class="login-sub">// painel mestre — somente administradores</p>

    @if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        > {{ $error }}<br>
      @endforeach
    </div>
    @endif

    <form method="POST" action="/superadmin/login">
      @csrf
      <div class="form-group">
        <label class="form-label">> email</label>
        <input class="form-input" type="email" name="email" placeholder="root@studiopro.tech" value="{{ old('email') }}" required autofocus/>
      </div>
      <div class="form-group">
        <label class="form-label">> senha</label>
        <input class="form-input" type="password" name="password" placeholder="••••••••••••" required/>
      </div>
      <button type="submit" class="btn-login">[ AUTENTICAR ]</button>
    </form>

    <a href="/" class="back-link">← exit /home</a>
  </div>
</div>

<footer>
  <p>StudioPro System v1.0 · acesso monitorado</p>
</footer>

<script>
document.addEventListener('gesturestart', function(e) { e.preventDefault(); });
document.addEventListener('touchmove', function(e) { if(e.scale !== 1) e.preventDefault(); }, { passive: false });
</script>
</body>
</html>