@component('mail::message')
<div style="background:#000000;padding:0;margin:0">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#000000">
<tr><td align="center" style="padding:30px 20px">

<table width="100%" style="max-width:480px;background:#0a0a0a;border:1px solid #1a1a1a;border-radius:8px;overflow:hidden">

<tr><td style="background:#000000;border-bottom:3px solid #DC2626;padding:24px;text-align:center">
<span style="font-family:Arial,sans-serif;font-size:24px;font-weight:900;letter-spacing:2px;color:#ffffff">BARBER<span style="color:#DC2626">PRO</span></span>
</td></tr>

<tr><td style="padding:32px 28px">
<p style="font-family:Arial,sans-serif;font-size:16px;color:#ffffff;margin:0 0 16px 0">Olá, {{ $tenant->nome }}! ⏰</p>

@if($diasRestantes === 1)
<p style="font-family:Arial,sans-serif;font-size:15px;color:#D1D5DB;line-height:1.6;margin:0 0 20px 0">Sua mensalidade do <strong style="color:#fff">StudioPro</strong> vence <strong style="color:#DC2626">amanhã</strong>!</p>
@else
<p style="font-family:Arial,sans-serif;font-size:15px;color:#D1D5DB;line-height:1.6;margin:0 0 20px 0">Sua mensalidade do <strong style="color:#fff">StudioPro</strong> vence em <strong style="color:#DC2626">{{ $diasRestantes }} dias</strong>!</p>
@endif

<table width="100%" style="background:#000000;border:1px solid #1a1a1a;border-radius:6px;margin-bottom:24px">
<tr><td style="padding:16px 20px">
<p style="font-family:Arial,sans-serif;font-size:12px;color:#6B7280;text-transform:uppercase;letter-spacing:1px;margin:0 0 4px 0">Valor da mensalidade</p>
<p style="font-family:Arial,sans-serif;font-size:28px;font-weight:900;color:#ffffff;margin:0">R$ {{ number_format($tenant->mensalidade, 2, ',', '.') }}</p>
</td></tr>
</table>

<p style="font-family:Arial,sans-serif;font-size:14px;color:#9CA3AF;line-height:1.6;margin:0 0 24px 0">Para evitar a interrupção do seu sistema de agendamentos, entre em contato conosco para renovar sua assinatura.</p>

<table width="100%" cellpadding="0" cellspacing="0">
<tr><td align="center">
<a href="https://wa.me/5513974083045" style="display:inline-block;background:#DC2626;color:#ffffff;font-family:Arial,sans-serif;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:6px;letter-spacing:.5px">FALAR NO WHATSAPP</a>
</td></tr>
</table>
</td></tr>

<tr><td style="padding:20px 28px;border-top:1px solid #1a1a1a;text-align:center">
<p style="font-family:Arial,sans-serif;font-size:11px;color:#4B5563;margin:0">StudioPro — Sistema de Agendamento para Barbearias</p>
</td></tr>

</table>
</td></tr>
</table>
</div>
@endcomponent
