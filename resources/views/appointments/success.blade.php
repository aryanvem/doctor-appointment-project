@extends('layouts.app')

@section('title', 'Booking Confirmed - DoctorsApp')

@push('styles')
<style>
    .success-wrapper {
        min-height: 80vh; display: flex;
        align-items: center; justify-content: center; padding: 40px 16px;
    }
    .success-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: 18px; overflow: hidden;
        width: 100%; max-width: 520px;
        box-shadow: 0 8px 32px rgba(0,0,0,.1);
        text-align: center;
    }
    .success-top {
        background: linear-gradient(135deg, #27ae60, #1d8348);
        padding: 40px 32px 32px; color: #fff;
    }
    .success-icon {
        width: 80px; height: 80px;
        background: rgba(255,255,255,.2);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem; margin: 0 auto 16px;
        animation: popIn .5s cubic-bezier(.175,.885,.32,1.275);
    }
    @keyframes popIn {
        from { transform: scale(0); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }
    .success-top h3 { font-weight: 800; font-size: 1.5rem; margin-bottom: 6px; }
    .success-top p  { opacity: .85; margin: 0; font-size: .95rem; }
    .booking-ref {
        display: inline-block; background: rgba(255,255,255,.18);
        border: 1.5px dashed rgba(255,255,255,.5);
        border-radius: 8px; padding: 8px 20px; margin-top: 16px;
        font-size: 1.1rem; font-weight: 700; letter-spacing: 2px;
    }
    .success-body { padding: 28px 32px; }
    .appt-detail {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 0; border-bottom: 1px solid var(--border);
        font-size: .92rem;
    }
    .appt-detail:last-of-type { border-bottom: none; }
    .appt-label { color: var(--text-muted); font-weight: 500; }
    .appt-value { font-weight: 600; }
    .btn-home {
        display: block; width: 100%;
        background: var(--primary); color: #fff;
        border: none; border-radius: 8px; padding: 13px;
        font-weight: 700; font-size: 1rem; text-decoration: none;
        margin-top: 24px; transition: background .2s;
    }
    .btn-home:hover { background: var(--primary-dark); color: #fff; }
    .btn-my-appts {
        display: block; text-align: center;
        color: var(--primary); font-size: .9rem; margin-top: 12px;
        text-decoration: none; font-weight: 500;
    }
    .email-note {
        background: #f0fafe; border: 1px solid #b3e5fc;
        border-radius: 8px; padding: 10px 14px;
        font-size: .83rem; color: #0277bd; margin: 16px 0 0;
    }
</style>
@endpush

@section('content')
<div class="success-wrapper">
    <div class="success-card">
        <div class="success-top">
            <div class="success-icon"><i class="fas fa-check"></i></div>
            <h3>Appointment Booked!</h3>
            <p>Your appointment has been confirmed</p>
            <div class="booking-ref">{{ $appointment->booking_ref }}</div>
        </div>

        <div class="success-body">
            <div class="appt-detail">
                <span class="appt-label"><i class="fas fa-user-md me-2 text-primary"></i>Doctor</span>
                <span class="appt-value">{{ $appointment->doctor->name }}</span>
            </div>
            <div class="appt-detail">
                <span class="appt-label"><i class="fas fa-hospital me-2 text-primary"></i>Clinic</span>
                <span class="appt-value">{{ $appointment->clinic->name }}</span>
            </div>
            <div class="appt-detail">
                <span class="appt-label"><i class="fas fa-calendar me-2 text-primary"></i>Date</span>
                <span class="appt-value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D, d M Y') }}</span>
            </div>
            <div class="appt-detail">
                <span class="appt-label"><i class="fas fa-clock me-2 text-primary"></i>Time</span>
                <span class="appt-value">{{ $appointment->slot->formatted_time }}</span>
            </div>
            <div class="appt-detail">
                <span class="appt-label"><i class="fas fa-tag me-2 text-primary"></i>Visit Type</span>
                <span class="appt-value">{{ $appointment->appointment_type === 'first_visit' ? 'First Visit' : 'Follow Up' }}</span>
            </div>

            <div class="email-note">
                <i class="fas fa-envelope me-1"></i>
                A confirmation has been sent to <strong>{{ session('user_email') }}</strong>
            </div>

            <a href="{{ route('doctor.show', ['slug' => $appointment->doctor->slug, 'phone' => $appointment->doctor->phone]) }}"
               class="btn-home">
                <i class="fas fa-plus me-2"></i>Book Another Appointment
            </a>
            <a href="{{ route('appointments.index') }}" class="btn-my-appts">
                <i class="fas fa-list me-1"></i>View My Appointments
            </a>
        </div>
    </div>
</div>
@endsection
