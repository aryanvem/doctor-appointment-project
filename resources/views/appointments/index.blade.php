@extends('layouts.app')

@section('title', 'My Appointments - DoctorsApp')

@push('styles')
<style>
    .page-header {
        background: #fff; border-bottom: 1px solid var(--border);
        padding: 24px 0; margin-bottom: 28px;
    }
    .page-header h4 { font-weight: 700; margin: 0; }
    .appt-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: 12px; padding: 20px 24px;
        margin-bottom: 16px; display: flex;
        justify-content: space-between; align-items: center;
        gap: 16px; transition: box-shadow .2s;
    }
    .appt-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }
    .appt-card-left { flex: 1; }
    .appt-doctor { font-weight: 700; font-size: 1rem; margin-bottom: 4px; }
    .appt-info    { font-size: .85rem; color: var(--text-muted); }
    .appt-info span { margin-right: 16px; }
    .appt-info i  { margin-right: 4px; color: var(--primary); }
    .appt-ref { font-size: .78rem; color: #aaa; margin-top: 6px; font-family: monospace; letter-spacing:1px; }
    .badge-booked    { background: #e8f8f0; color: #27ae60; border: 1px solid #a9dfbf; }
    .badge-cancelled { background: #fdf0f0; color: #c0392b; border: 1px solid #f5c6cb; }
    .badge-completed { background: #eaf2fb; color: #2980b9; border: 1px solid #aed6f1; }
    .badge-status {
        padding: 5px 14px; border-radius: 20px; font-size: .8rem; font-weight: 600;
    }
    .empty-state {
        text-align: center; padding: 60px 20px;
        background: #fff; border: 1px solid var(--border); border-radius: 14px;
    }
    .empty-state i { font-size: 3rem; color: #ddd; margin-bottom: 16px; }
    .empty-state h5 { color: var(--text-muted); font-weight: 600; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h4><i class="fas fa-calendar-check me-2 text-primary"></i>My Appointments</h4>
    </div>
</div>

<div class="container pb-5">
    @if($appointments->isEmpty())
        <div class="empty-state">
            <div><i class="fas fa-calendar-times"></i></div>
            <h5>No appointments yet</h5>
            <p class="text-muted mb-4">You haven't booked any appointments.</p>
            <a href="/" class="btn btn-primary">Book an Appointment</a>
        </div>
    @else
        @foreach($appointments as $appt)
            <div class="appt-card">
                <div class="appt-card-left">
                    <div class="appt-doctor">
                        <i class="fas fa-user-md me-2 text-primary"></i>{{ $appt->doctor->name }}
                        <small class="text-muted fw-normal">— {{ $appt->doctor->specialization }}</small>
                    </div>
                    <div class="appt-info mt-1">
                        <span><i class="fas fa-hospital"></i>{{ $appt->clinic->name }}</span>
                        <span><i class="fas fa-calendar"></i>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}</span>
                        <span><i class="fas fa-clock"></i>{{ $appt->slot->formatted_time }}</span>
                        <span><i class="fas fa-tag"></i>{{ $appt->appointment_type === 'first_visit' ? 'First Visit' : 'Follow Up' }}</span>
                    </div>
                    <div class="appt-ref">Ref: {{ $appt->booking_ref }}</div>
                </div>
                <div>
                    <span class="badge-status badge-{{ $appt->status }}">
                        {{ ucfirst($appt->status) }}
                    </span>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
