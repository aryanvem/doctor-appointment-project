<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DoctorsApp - Book Appointments')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #00b0b9;
            --primary-dark: #008a92;
            --orange: #ff6b35;
            --light-bg: #f7f9fc;
            --border: #e8edf2;
            --text-dark: #1a2332;
            --text-muted: #6b7c93;
            --slot-available: #e8f8f0;
            --slot-available-border: #27ae60;
            --slot-booked: #f0f0f0;
            --slot-booked-border: #bbb;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--light-bg);
            color: var(--text-dark);
        }

        /* ── Navbar ── */
        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
        }
        .navbar { background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
        .navbar .nav-link { color: var(--text-dark) !important; font-weight: 500; }

        /* ── Cards ── */
        .card { border: 1px solid var(--border); border-radius: 12px; }
        .card-header { background: #fff; border-bottom: 1px solid var(--border); font-weight: 600; }

        /* ── Buttons ── */
        .btn-primary {
            background: var(--orange);
            border-color: var(--orange);
            font-weight: 600;
            border-radius: 6px;
        }
        .btn-primary:hover { background: #e05a26; border-color: #e05a26; }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); }

        /* ── Alerts ── */
        .alert { border-radius: 10px; font-size: .92rem; }

        /* ── Footer ── */
        footer { background: #fff; border-top: 1px solid var(--border); font-size: .85rem; }
    </style>

    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-stethoscope me-1"></i>DoctorsApp
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @if(session('user_id'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('appointments.index') }}">
                            <i class="fas fa-calendar-check me-1"></i>My Appointments
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-muted">
                            <i class="fas fa-user-circle me-1"></i>{{ session('user_name') }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-sm btn-primary" href="{{ route('auth.login') }}">Login / Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
<div class="container mt-3">
    @foreach(['success','info','warning','danger'] as $type)
        @if(session($type))
            <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                {{ session($type) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach
    @if(session('demo_otp'))
        <div class="alert alert-warning alert-dismissible fade show">
            <strong>📧 Demo Mode:</strong> Your OTP is <strong>{{ session('demo_otp') }}</strong>
            (Mail not configured — shown here for testing)
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- Page Content --}}
@yield('content')

<footer class="py-3 mt-5">
    <div class="container text-center text-muted">
        &copy; {{ date('Y') }} DoctorsApp &mdash; Online Appointment System
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
