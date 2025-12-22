<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PCTechno</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    .auth-bg{
      min-height:100vh;
      background: linear-gradient(135deg, var(--pc-blue), #0d2f7a);
      display:flex;
      align-items:center;
      justify-content:center;
      padding: 2rem 1rem;
    }
    .auth-card{
      width: 100%;
      max-width: 420px;
      border-radius: 14px;
      overflow:hidden;
      box-shadow: 0 12px 40px rgba(0,0,0,.18);
      background:#fff;
    }
    .auth-header{
      background: var(--pc-blue-2);
      color:#fff;
      padding: 2.2rem 1.8rem;
      text-align:center;
      position:relative;
    }
    .auth-logo{
      width:56px;height:56px;border-radius:16px;
      background: var(--pc-yellow);
      display:flex;align-items:center;justify-content:center;
      margin:0 auto 14px auto;
      font-weight:900;
      color:#111;
    }
    .auth-title{ font-size: 1.6rem; font-weight: 800; margin:0; }
    .auth-sub{ opacity:.9; margin-top:.25rem; font-size:.95rem; }
    .auth-body{ padding: 1.6rem 1.6rem 1.2rem; }
    .dark-input{
      background:#3a3a3a;
      border: none;
      color:#fff;
      height: 44px;
      border-radius:10px;
    }
    .dark-input::placeholder{ color: rgba(255,255,255,.65); }
    .demo-cred{ font-size:.78rem; color:#6b7280; text-align:center; margin-top:.9rem; }
  </style>
</head>
<body>
  <div class="auth-bg">
    <div class="auth-card">
      @yield('content')
    </div>
  </div>
</body>
</html>
