<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DoctorsApp</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Nunito', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f0f4ff; padding: 20px; }
        .bg-packages { position: fixed; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
        .float-pkg { position: absolute; opacity: 0.07; animation: floatPkg 6s ease-in-out infinite; }
        @keyframes floatPkg { 0%,100%{transform:translateY(0) rotate(0deg)} 50%{transform:translateY(-20px) rotate(8deg)} }
        .card { position: relative; z-index: 1; display: flex; width: 100%; max-width: 900px; min-height: 560px; border-radius: 28px; overflow: hidden; box-shadow: 0 24px 60px rgba(58,123,213,.18), 0 8px 24px rgba(0,0,0,.10); animation: slideUp .6s cubic-bezier(.22,.68,0,1.2) both; }
        @keyframes slideUp { from{opacity:0;transform:translateY(40px)} to{opacity:1;transform:translateY(0)} }
        .left-panel { flex: 0 0 380px; background: linear-gradient(145deg, #1a2f6e 0%, #3a7bd5 60%, #5b9ef5 100%); padding: 48px 36px; display: flex; flex-direction: column; position: relative; overflow: hidden; animation: slideInLeft .7s cubic-bezier(.22,.68,0,1.2) both; }
        @keyframes slideInLeft { from{opacity:0;transform:translateX(-40px)} to{opacity:1;transform:translateX(0)} }
        .left-panel::before { content:''; position:absolute; inset:0; background: radial-gradient(circle at 70% 20%, rgba(255,255,255,.08) 0%, transparent 60%); }
        .brand { font-family: 'Fredoka One', sans-serif; color: #fff; font-size: 1.8rem; letter-spacing: -.5px; display: flex; align-items: center; gap: 8px; }
        .brand-dot { width:10px;height:10px;background:#ff6b35;border-radius:50%; }
        .left-tagline { margin-top: 32px; font-family: 'Fredoka One', sans-serif; color: #fff; font-size: 2rem; line-height: 1.2; }
        .left-sub { margin-top: 10px; color: rgba(255,255,255,.75); font-size: .9rem; font-weight: 600; line-height: 1.5; }
        .character-wrap { width: 180px; height: 260px; animation: walkBounce 0.6s ease-in-out infinite; margin: 24px auto; }
        @keyframes walkBounce { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-7px)} }
        .leg-right { animation: legRight .6s ease-in-out infinite; transform-origin: 108px 200px; }
        .leg-left  { animation: legLeft  .6s ease-in-out infinite; transform-origin:  88px 200px; }
        @keyframes legRight { 0%,100%{transform:rotate(-18deg)} 50%{transform:rotate(18deg)} }
        @keyframes legLeft  { 0%,100%{transform:rotate(18deg)}  50%{transform:rotate(-18deg)} }
        .arm-swing { animation: armSwing .6s ease-in-out infinite; transform-origin: 68px 148px; }
        @keyframes armSwing { 0%,100%{transform:rotate(-20deg)} 50%{transform:rotate(20deg)} }
        .bob-pkg   { animation: bobPkg 1.2s ease-in-out infinite; }
        @keyframes bobPkg { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-4px)} }
        .stats { display: flex; gap: 24px; margin-top: 16px; }
        .stat-val  { font-family:'Fredoka One',sans-serif; color:#fff; font-size:1.1rem; }
        .stat-label{ color:rgba(255,255,255,.6); font-size:.75rem; font-weight:700; margin-top:1px; }
        .right-panel { flex: 1; background: #fff; padding: 48px 44px; display: flex; flex-direction: column; justify-content: center; animation: slideInRight .7s cubic-bezier(.22,.68,0,1.2) both; }
        @keyframes slideInRight { from{opacity:0;transform:translateX(40px)} to{opacity:1;transform:translateX(0)} }
        .welcome-title { font-family: 'Fredoka One', sans-serif; font-size: 2rem; color: #1a2540; line-height: 1.1; }
        .welcome-sub { color: #6b7fa3; font-size: .88rem; font-weight: 700; margin-top: 4px; margin-bottom: 28px; }
        .alert { padding: 10px 14px; border-radius: 10px; font-size: .85rem; font-weight: 700; margin-bottom: 16px; }
        .alert-danger  { background:#fdf0f0; color:#c0392b; border:1px solid #f5c6cb; }
        .alert-success { background:#f0faf0; color:#27ae60; border:1px solid #a9dfbf; }
        .alert-warning { background:#fffbf0; color:#d68910; border:1px solid #fad7a0; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: .72rem; font-weight: 900; color: #1a2540; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; }
        .input-wrap { display: flex; align-items: center; gap: 10px; border: 2px solid #e8edf6; border-radius: 14px; padding: 11px 14px; background: #f5f8ff; transition: border-color .2s, background .2s, box-shadow .2s; }
        .input-wrap:focus-within { border-color: #ff6b35; background: #fff8f5; box-shadow: 0 0 0 3px rgba(255,107,53,.1); }
        .input-wrap input { flex: 1; border: none; outline: none; background: transparent; font-size: .9rem; font-weight: 700; color: #1a2540; font-family: 'Nunito', sans-serif; }
        .input-wrap input::placeholder { color: #b0bed8; font-weight: 600; }
        .input-icon { color: #6b7fa3; flex-shrink: 0; transition: color .2s; }
        .input-wrap:focus-within .input-icon { color: #ff6b35; }
        .forgot-row { text-align: right; margin-top: -8px; margin-bottom: 16px; }
        .forgot-link { font-size:.78rem; font-weight:800; color:#3a7bd5; text-decoration:none; }
        .forgot-link:hover { color:#ff6b35; }
        .btn-submit { width: 100%; padding: 14px; border: none; border-radius: 14px; cursor: pointer; font-family: 'Fredoka One', sans-serif; font-size: 1.05rem; letter-spacing: .03em; color: #fff; background: linear-gradient(135deg, #ff6b35 0%, #e84e1b 100%); box-shadow: 0 6px 20px rgba(255,107,53,.35); display: flex; align-items: center; justify-content: center; gap: 8px; transition: transform .15s, box-shadow .15s; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(255,107,53,.4); }
        .btn-submit:active { transform: scale(.97); }
        .divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
        .divider-line { flex:1; height:1px; background:#e8edf6; }
        .divider-text { font-size:.72rem; font-weight:900; color:#b0bed8; }
        .social-grid { display: grid; grid-template-columns:1fr 1fr; gap: 10px; }
        .social-btn { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 11px; border: 2px solid #e8edf6; border-radius: 14px; background: #f5f8ff; cursor: pointer; font-size: .85rem; font-weight: 800; color: #1a2540; text-decoration: none; transition: border-color .2s, background .2s; font-family: 'Nunito', sans-serif; }
        .social-btn:hover { border-color: #3a7bd5; background: #eef4ff; }
        .register-link { text-align: center; margin-top: 18px; font-size: .85rem; color: #6b7fa3; font-weight: 700; }
        .register-link a { color: #ff6b35; font-weight: 900; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
        .field-error { color:#c0392b; font-size:.78rem; font-weight:700; margin-top:4px; }
        .shake { animation: shake .4s both; }
        @keyframes shake { 0%,100%{transform:translateX(0)} 20%{transform:translateX(-8px)} 40%{transform:translateX(8px)} 60%{transform:translateX(-6px)} 80%{transform:translateX(6px)} }
        @media (max-width: 700px) { .left-panel { display: none; } .right-panel { padding: 36px 24px; } }
    </style>
</head>
<body>

<div class="bg-packages">
    <div class="float-pkg" style="left:10%;top:15%;animation-delay:0s;width:48px;height:48px;"><svg viewBox="0 0 40 40" fill="none"><rect x="4" y="12" width="32" height="24" rx="4" fill="#3a7bd5"/><rect x="4" y="22" width="32" height="4" fill="#2563c0"/></svg></div>
    <div class="float-pkg" style="left:80%;top:10%;animation-delay:1s;width:36px;height:36px;"><svg viewBox="0 0 40 40" fill="none"><rect x="4" y="12" width="32" height="24" rx="4" fill="#ff6b35"/><rect x="4" y="22" width="32" height="4" fill="#e84e1b"/></svg></div>
    <div class="float-pkg" style="left:25%;top:70%;animation-delay:2s;width:56px;height:56px;"><svg viewBox="0 0 40 40" fill="none"><rect x="4" y="12" width="32" height="24" rx="4" fill="#ffd166"/><rect x="4" y="22" width="32" height="4" fill="#e8b800"/></svg></div>
    <div class="float-pkg" style="left:65%;top:55%;animation-delay:1.5s;width:40px;height:40px;"><svg viewBox="0 0 40 40" fill="none"><rect x="4" y="12" width="32" height="24" rx="4" fill="#3a7bd5"/><rect x="4" y="22" width="32" height="4" fill="#2563c0"/></svg></div>
    <div class="float-pkg" style="left:90%;top:75%;animation-delay:2.2s;width:44px;height:44px;"><svg viewBox="0 0 40 40" fill="none"><rect x="4" y="12" width="32" height="24" rx="4" fill="#ff6b35"/><rect x="4" y="22" width="32" height="4" fill="#e84e1b"/></svg></div>
</div>

<div class="card">

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="brand"><div class="brand-dot"></div>DoctorsApp</div>
        <div class="left-tagline">Book your doctor,<br>anytime. 🩺</div>
        <div class="left-sub">Fast, easy appointments with<br>verified doctors near you.</div>

        <div class="character-wrap">
            <svg viewBox="0 0 200 280" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%">
                <ellipse cx="100" cy="268" rx="38" ry="8" fill="rgba(0,0,0,0.12)"/>
                <g class="leg-right"><rect x="100" y="195" width="16" height="44" rx="8" fill="#1a2540"/><ellipse cx="112" cy="241" rx="12" ry="7" fill="#ff6b35"/></g>
                <g class="leg-left"><rect x="80" y="195" width="16" height="44" rx="8" fill="#1a2540"/><ellipse cx="88" cy="241" rx="12" ry="7" fill="#ff6b35"/></g>
                <rect x="68" y="130" width="64" height="72" rx="18" fill="#3a7bd5"/>
                <rect x="92" y="130" width="16" height="72" rx="4" fill="#2563c0"/>
                <rect x="96" y="145" width="8" height="8" rx="2" fill="#ffd166"/>
                <g class="bob-pkg"><rect x="118" y="118" width="44" height="38" rx="6" fill="#ffd166"/><rect x="137" y="118" width="6" height="38" fill="#e8b800"/><rect x="118" y="134" width="44" height="5" fill="#e8b800"/><rect x="122" y="122" width="10" height="6" rx="2" fill="rgba(255,255,255,0.4)"/></g>
                <path d="M132 148 Q148 140 152 130" stroke="#f4c07a" stroke-width="14" stroke-linecap="round" fill="none"/>
                <g class="arm-swing"><path d="M68 148 Q50 158 48 172" stroke="#f4c07a" stroke-width="14" stroke-linecap="round" fill="none"/><circle cx="47" cy="175" r="9" fill="#f4c07a"/></g>
                <rect x="88" y="118" width="24" height="16" rx="6" fill="#f4c07a"/>
                <ellipse cx="100" cy="100" rx="34" ry="32" fill="#f4c07a"/>
                <path d="M68 96 Q72 62 100 60 Q128 62 132 96" fill="#3d2314"/>
                <path d="M80 68 Q84 52 92 60" fill="#3d2314"/><path d="M100 60 Q104 44 112 56" fill="#3d2314"/><path d="M116 66 Q124 52 128 64" fill="#3d2314"/>
                <ellipse cx="66" cy="100" rx="8" ry="10" fill="#f4c07a"/><ellipse cx="134" cy="100" rx="8" ry="10" fill="#f4c07a"/>
                <ellipse cx="66" cy="100" rx="4" ry="6" fill="#e8a060"/><ellipse cx="134" cy="100" rx="4" ry="6" fill="#e8a060"/>
                <ellipse cx="88" cy="98" rx="8" ry="9" fill="white"/><ellipse cx="112" cy="98" rx="8" ry="9" fill="white"/>
                <circle cx="90" cy="100" r="5" fill="#2d1a08"/><circle cx="114" cy="100" r="5" fill="#2d1a08"/>
                <circle cx="92" cy="97" r="2" fill="white"/><circle cx="116" cy="97" r="2" fill="white"/>
                <path d="M82 88 Q88 84 94 88" stroke="#3d2314" stroke-width="3" stroke-linecap="round" fill="none"/>
                <path d="M106 88 Q112 84 118 88" stroke="#3d2314" stroke-width="3" stroke-linecap="round" fill="none"/>
                <path d="M88 112 Q100 122 112 112" stroke="#e06040" stroke-width="3" stroke-linecap="round" fill="none"/>
                <ellipse cx="78" cy="110" rx="8" ry="5" fill="rgba(255,130,100,0.4)"/>
                <ellipse cx="122" cy="110" rx="8" ry="5" fill="rgba(255,130,100,0.4)"/>
                <path d="M66 92 Q68 68 100 66 Q132 68 134 92 Z" fill="#ff6b35"/>
                <rect x="62" y="90" width="76" height="10" rx="5" fill="#e85520"/>
                <path d="M62 96 Q50 96 52 104 Q60 108 70 100" fill="#e85520"/>
                <text x="93" y="84" font-size="10" fill="white" font-weight="bold">▶</text>
            </svg>
        </div>

        <div class="stats">
            <div><div class="stat-val">12k+</div><div class="stat-label">Patients</div></div>
            <div><div class="stat-val">98%</div><div class="stat-label">On-time</div></div>
            <div><div class="stat-val">4.9★</div><div class="stat-label">Rating</div></div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="welcome-title">Welcome back! 👋</div>
        <div class="welcome-sub">Login to book your appointment</div>

        @if(session('demo_otp'))
            <div class="alert alert-warning">📧 Demo OTP: <strong>{{ session('demo_otp') }}</strong></div>
        @endif
        @if(session('info'))
            <div class="alert alert-warning">{{ session('info') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('auth.send-otp') }}" method="POST" id="loginForm">
            @csrf
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    <input type="text" name="name" placeholder="e.g. Rahul Sharma" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="forgot-row">
                <a href="#" class="forgot-link">Need help? Contact support</a>
            </div>

            <button type="submit" class="btn-submit">
                Send OTP to Email
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>

        <div class="divider"><div class="divider-line"></div><span class="divider-text">OR</span><div class="divider-line"></div></div>

        <div class="social-grid">
            <a href="#" class="social-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Google
            </a>
            <a href="#" class="social-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="1" y="1" width="10" height="10" fill="#F25022"/><rect x="13" y="1" width="10" height="10" fill="#7FBA00"/><rect x="1" y="13" width="10" height="10" fill="#00A4EF"/><rect x="13" y="13" width="10" height="10" fill="#FFB900"/></svg>
                Microsoft
            </a>
        </div>

        <div class="register-link">New here? <a href="{{ route('auth.login') }}">Create an account</a></div>
    </div>
</div>

<script>
@if($errors->any())
document.getElementById('loginForm').classList.add('shake');
setTimeout(() => document.getElementById('loginForm').classList.remove('shake'), 500);
@endif
</script>
</body>
</html>
