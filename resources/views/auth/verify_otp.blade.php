@extends('layouts.app')

@section('title', 'Verify OTP - DoctorsApp')

@push('styles')
<style>
    .auth-wrapper {
        min-height: 80vh;
        display: flex; align-items: center; justify-content: center;
        padding: 40px 16px;
    }
    .auth-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: 16px; padding: 40px 36px;
        width: 100%; max-width: 440px;
        box-shadow: 0 4px 24px rgba(0,0,0,.07);
    }
    .auth-icon {
        width: 64px; height: 64px;
        background: linear-gradient(135deg, #27ae60, #1d8348);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.6rem;
        margin: 0 auto 20px;
    }
    .auth-title { font-size: 1.4rem; font-weight: 700; text-align: center; margin-bottom: 6px; }
    .auth-sub   { font-size: .9rem; color: var(--text-muted); text-align: center; margin-bottom: 28px; }
    .otp-inputs {
        display: flex; gap: 10px; justify-content: center; margin-bottom: 24px;
    }
    .otp-box {
        width: 52px; height: 56px;
        border: 2px solid var(--border); border-radius: 10px;
        font-size: 1.5rem; font-weight: 700; text-align: center;
        transition: border-color .2s; outline: none;
    }
    .otp-box:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0,176,185,.15); }
    .otp-box.filled { border-color: var(--primary); background: #e6f9fb; }
    .btn-auth {
        width: 100%; background: var(--orange); color: #fff;
        border: none; border-radius: 8px; padding: 13px;
        font-weight: 700; font-size: 1rem; cursor: pointer;
        transition: background .2s, transform .15s;
    }
    .btn-auth:hover {
        background: #e05a26; transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255,107,53,.3);
    }
    .resend-link { font-size: .86rem; color: var(--text-muted); text-align: center; margin-top: 16px; }
    .resend-link a { color: var(--primary); text-decoration: none; font-weight: 600; }
    #otpHidden { display: none; }
    .timer { font-weight: 600; color: #e74c3c; }
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-icon"><i class="fas fa-envelope-open-text"></i></div>
        <div class="auth-title">Enter OTP</div>
        <div class="auth-sub">
            We've sent a 6-digit OTP to<br>
            <strong>{{ session('pending_user_email') }}</strong>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2 mb-3">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('auth.verify-otp') }}" method="POST" id="otpForm">
            @csrf
            <input type="hidden" name="otp" id="otpHidden">

            <div class="otp-inputs">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" class="otp-box"
                           data-index="{{ $i }}" inputmode="numeric" pattern="[0-9]">
                @endfor
            </div>

            <button type="submit" class="btn-auth" id="verifyBtn">
                <i class="fas fa-check-circle me-2"></i>Verify OTP
            </button>
        </form>

        <div class="resend-link mt-3">
            OTP expires in <span id="countdown" class="timer">10:00</span>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="{{ route('auth.login') }}">Change email</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// OTP box auto-advance
const boxes = document.querySelectorAll('.otp-box');

boxes.forEach((box, i) => {
    box.addEventListener('input', e => {
        const val = e.target.value.replace(/\D/g, '');
        e.target.value = val;
        if (val && i < boxes.length - 1) boxes[i + 1].focus();
        updateHidden();
        box.classList.toggle('filled', !!val);
    });
    box.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !box.value && i > 0) {
            boxes[i - 1].focus();
            boxes[i - 1].value = '';
            boxes[i - 1].classList.remove('filled');
            updateHidden();
        }
    });
    box.addEventListener('paste', e => {
        e.preventDefault();
        const paste = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
        [...paste].forEach((ch, idx) => {
            if (boxes[idx]) { boxes[idx].value = ch; boxes[idx].classList.add('filled'); }
        });
        updateHidden();
        if (boxes[paste.length - 1]) boxes[Math.min(paste.length, 5)].focus();
    });
});

function updateHidden() {
    document.getElementById('otpHidden').value = [...boxes].map(b => b.value).join('');
}

// Countdown timer
let secs = 600;
const countEl = document.getElementById('countdown');
const timer = setInterval(() => {
    secs--;
    const m = String(Math.floor(secs / 60)).padStart(2, '0');
    const s = String(secs % 60).padStart(2, '0');
    countEl.textContent = `${m}:${s}`;
    if (secs <= 0) { clearInterval(timer); countEl.textContent = 'Expired'; }
}, 1000);

boxes[0].focus();
</script>
@endpush
