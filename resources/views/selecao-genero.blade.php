<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>StudioPro</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{background:#000;color:#fff;font-family:'Inter',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center}
    .container{text-align:center;padding:40px 20px;max-width:500px;width:100%}
    .logo{font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:6px;margin-bottom:8px}
    .logo span{color:#C9A84C}
    .subtitle{color:#6B7280;font-size:14px;letter-spacing:2px;text-transform:uppercase;margin-bottom:60px}
    .question{font-size:22px;font-weight:600;margin-bottom:12px;color:#fff}
    .question-sub{color:#6B7280;font-size:14px;margin-bottom:48px}
    .buttons{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
    .btn-genero{display:flex;flex-direction:column;align-items:center;gap:12px;padding:32px 48px;border-radius:12px;border:1px solid;cursor:pointer;text-decoration:none;transition:all .3s;width:180px;height:180px;justify-content:center}
    .btn-masculino{background:#0a0a0a;border-color:#C9A84C;color:#C9A84C}
    .btn-masculino:hover{background:#C9A84C;color:#000;box-shadow:0 8px 30px rgba(201,168,76,.4)}
    .btn-feminino{background:#0a0a0a;border-color:#ec4899;color:#ec4899}
    .btn-feminino:hover{background:#ec4899;color:#fff;box-shadow:0 8px 30px rgba(236,72,153,.4)}
    .btn-icon{font-size:40px}
    .btn-label{font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:3px}
    .btn-sub{font-size:11px;opacity:.7;letter-spacing:1px}
    .divider{width:1px;background:#1a1a1a;height:80px;align-self:center}
    @media(max-width:480px){.buttons{flex-direction:column;align-items:center}.divider{width:80px;height:1px}}
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">STUDIO<span>PRO</span></div>
    <div class="subtitle">Estética & Bem-estar</div>
    <div class="question">Para quem é o atendimento?</div>
    <div class="question-sub">Selecione para ver os serviços disponíveis</div>
    <div class="buttons">
      <a href="/agendar?genero=masculino" class="btn-genero btn-masculino">
        <span class="btn-icon">♂</span>
        <span class="btn-label">Masculino</span>
        <span class="btn-sub">Depilação & Tratamentos</span>
      </a>
      <div class="divider"></div>
      <a href="/agendar?genero=feminino" class="btn-genero btn-feminino">
        <span class="btn-icon">♀</span>
        <span class="btn-label">Feminino</span>
        <span class="btn-sub">Depilação & Estética</span>
      </a>
    </div>
  </div>
</body>
</html>
