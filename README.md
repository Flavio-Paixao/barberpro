# BarberPro 💈

> Sistema SaaS de agendamento online para barbearias — multi-tenant, com confirmação automática via WhatsApp e painel admin completo.

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white)
![AWS](https://img.shields.io/badge/AWS-EC2%20%7C%20S3%20%7C%20CloudFront-FF9900?style=flat&logo=amazonaws&logoColor=white)
![Mercado Pago](https://img.shields.io/badge/Mercado%20Pago-009EE3?style=flat&logo=mercadopago&logoColor=white)
![Status](https://img.shields.io/badge/Status-Produção-22c55e?style=flat)

🌐 **Site:** [barberpro.tech](https://barberpro.tech) | 📱 **App:** [app.barberpro.tech](https://app.barberpro.tech)

---

## 📋 Sobre o Projeto

O **BarberPro** é uma plataforma SaaS multi-tenant que permite que barbearias ofereçam agendamento online 24h para seus clientes, com confirmação automática via WhatsApp, painel admin completo e cobrança automatizada via Mercado Pago.

Cada barbearia recebe um subdomínio próprio (`barbearia.barberpro.tech`), banco de dados isolado e acesso a um painel personalizado com sua logo, serviços e barbeiros.

---

## ✨ Funcionalidades

### Para o Cliente (Público)
- ✅ Agendamento online 24h pelo celular — sem precisar instalar app
- ✅ Escolha de barbeiro, serviço, data e horário disponível
- ✅ Confirmação automática via WhatsApp com todos os detalhes
- ✅ Lembrete automático 20 minutos antes do horário

### Para o Dono da Barbearia (Painel)
- ✅ Dashboard com agendamentos do dia, faturamento e métricas
- ✅ Lista completa de agendamentos com opção de cancelar
- ✅ Visualização de barbeiros e serviços cadastrados
- ✅ Relatório de faturamento estimado

### Para o Super Admin (Você)
- ✅ Painel central de todos os tenants
- ✅ Ativar/desativar barbearias
- ✅ Editar dados cadastrais, barbeiros e serviços
- ✅ Upload de logo da barbearia e fotos dos barbeiros
- ✅ Controle de mensalidade e modalidade de cobrança
- ✅ Notas internas por cliente
- ✅ Gráfico de faturamento por tenant (últimos 6 meses)
- ✅ Renovar trial com dias customizáveis

### Automações
- ✅ Job diário às 09h verificando vencimentos
- ✅ Aviso via WhatsApp + e-mail com link de pagamento 3 dias antes do vencimento
- ✅ Aviso via WhatsApp + e-mail com link de pagamento 1 dia antes
- ✅ Bloqueio automático após vencimento + notificação
- ✅ Geração automática de link de pagamento Mercado Pago

---

## 🛠️ Stack Tecnológico

| Camada | Tecnologia |
|---|---|
| Back-end | PHP 8.2, Laravel 11, Livewire |
| Front-end | HTML5, CSS3, JavaScript, Blade |
| Banco de Dados | SQLite (por tenant), MySQL (principal) |
| Hospedagem | AWS EC2 (Ubuntu 24 + Nginx) |
| CDN / SSL | AWS CloudFront + AWS ACM |
| Arquivos Estáticos | AWS S3 |
| DNS | AWS Route 53 + Hostinger |
| Pagamentos | Mercado Pago Checkout Pro + PIX |
| WhatsApp | Z-API |
| E-mail | Resend |
| Autenticação Social | Google OAuth (Laravel Socialite) |

---

## 🏗️ Arquitetura

```
┌─────────────────────────────────────────────────────┐
│                    DNS (Hostinger)                   │
│         barberpro.tech → CloudFront → S3            │
│      *.barberpro.tech → EC2 (Laravel App)           │
└─────────────────────────────────────────────────────┘
                          │
            ┌─────────────┴─────────────┐
            │                           │
    ┌───────▼───────┐         ┌─────────▼────────┐
    │  Landing Page │         │   Laravel App     │
    │  (S3 Static)  │         │   (EC2 + Nginx)   │
    └───────────────┘         └────────┬──────────┘
                                       │
              ┌────────────────────────┼────────────────────┐
              │                        │                     │
    ┌─────────▼──────┐     ┌──────────▼───────┐   ┌────────▼───────┐
    │  Multi-Tenant  │     │  Integrações      │   │  Jobs/Queues   │
    │  (SQLite/db)   │     │  - Mercado Pago  │   │  - Vencimentos │
    │  por barbearia │     │  - Z-API (WPP)   │   │  - Lembretes   │
    └────────────────┘     │  - Resend (mail)  │   │  - Bloqueios   │
                           │  - Google OAuth   │   └────────────────┘
                           └──────────────────┘
```

---

## 🚀 Instalação Local

```bash
# Clone o repositório
git clone https://github.com/flaviopaixao/barberpro.git
cd barberpro

# Instale as dependências
composer install
npm install

# Configure o ambiente
cp .env.example .env
php artisan key:generate

# Configure o banco de dados no .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barberpro
DB_USERNAME=root
DB_PASSWORD=

# Configure as integrações no .env
ZAPI_INSTANCE_ID=
ZAPI_TOKEN=
ZAPI_CLIENT_TOKEN=
ZAPI_BASE_URL=https://api.z-api.io

RESEND_API_KEY=
MAIL_FROM_ADDRESS=noreply@barberpro.tech

MERCADOPAGO_ACCESS_TOKEN=

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=

# Rode as migrations
php artisan migrate

# Crie um tenant de teste
php artisan tenant:criar "Barbearia Teste" teste

# Inicie o servidor
php artisan serve
```

---

## 📁 Estrutura do Projeto

```
barberpro/
├── app/
│   ├── Http/Controllers/
│   │   ├── AgendamentoController.php      # Agendamentos públicos
│   │   ├── PainelController.php           # Painel do dono
│   │   ├── SuperAdminController.php       # Super Admin
│   │   ├── SuperAdminTenantController.php # Gestão de tenants
│   │   ├── PagamentoController.php        # Mercado Pago
│   │   └── WebhookController.php          # Webhooks
│   ├── Jobs/
│   │   ├── VerificarVencimentos.php       # Job diário 09h
│   │   └── EnviarLembreteAgendamento.php  # Lembretes
│   ├── Mail/
│   │   ├── AvisoVencimentoMail.php
│   │   └── AvisoBloqueioMail.php
│   ├── Models/
│   │   ├── Tenant.php
│   │   └── Agendamento.php
│   └── Services/
│       ├── WhatsAppService.php            # Z-API
│       └── MercadoPagoService.php         # Pagamentos
├── database/
│   ├── migrations/
│   └── tenants/                           # SQLite por tenant
├── resources/views/
│   ├── agendamento/                       # Telas públicas
│   ├── painel/                            # Painel do dono
│   ├── superadmin/                        # Super Admin
│   └── emails/                            # Templates de e-mail
└── routes/
    └── web.php
```

---

## 🌍 Deploy em Produção

O projeto está em produção na AWS:

- **EC2:** `56.126.146.145` (Ubuntu 24 + Nginx + PHP 8.2)
- **S3:** Landing page estática (`barberpro.tech`)
- **CloudFront:** CDN + HTTPS para `barberpro.tech`
- **ACM:** Certificado SSL wildcard (`*.barberpro.tech`)
- **Route 53 / Hostinger:** DNS com Elastic IP fixo

---

## 📦 Planos Disponíveis

| Plano | Preço | Barbeiros | Destaques |
|---|---|---|---|
| Starter | R$49/mês | Até 2 | Agendamento 24h, WhatsApp, Plaquinhas, Google Meu Negócio |
| Pro | R$99/mês | Até 4 | + Faturamento, Agendamento manual, Suporte prioritário |
| Premium | R$149/mês | Ilimitados | + Domínio personalizado, Suporte VIP WhatsApp |

---

## 👨‍💻 Desenvolvedor

**Flávio da Paixão Nunes**
Full Stack Developer · Cloud Engineer · Santos, SP

- 🌐 [Portfólio](https://projeto-aws-681892816208-sa-east-1-an.s3.sa-east-1.amazonaws.com/index.html)
- 💼 [LinkedIn](https://linkedin.com/in/flaviopaixao)
- 🐙 [GitHub](https://github.com/flaviopaixao)

---

## 📄 Licença

Este projeto é proprietário. Todos os direitos reservados © 2026 Flávio Paixão.
