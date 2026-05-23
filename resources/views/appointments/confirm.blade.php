@extends('layouts.app')

@section('title', 'Confirm Appointment - DoctorsApp')

@push('styles')
<style>
    .confirm-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: 16px; overflow: hidden;
        max-width: 560px; margin: 0 auto;
        box-shadow: 0 4px 24px rgba(0,0,0,.07);
    }
    .confirm-header {
        background: linear-gradient(135deg, #00b0b9, #008a92);
        padding: 28px 32px; color: #fff;
    }
    .confirm-header h4 { font-weight: 700; margin: 0; font-size: 1.2rem; }
    .confirm-header p  { margin: 4px 0 0; opacity: .85; font-size: .9rem; }
    .confirm-body { padding: 28px 32px; }
    .detail-row {
        display: flex; justify-content: space-between; align-items: flex-start;
        padding: 12px 0; border-bottom: 1px solid var(--border); font-size: .93rem;
    }
    .detail-row:last-of-type { border-bottom: none; }
    .detail-label { color: var(--text-muted); font-weight: 500; flex-shrink: 0; margin-right: 16px; }
    .detail-value { font-weight: 600; text-align: right; }
    .fee-highlight {
        background: #fff8f0; border: 1.5px solid #ffb347;
        border-radius: 10px; padding: 14px 18px; margin: 20px 0;
        font-size: .9rem;
    }
    .fee-highlight .amount { font-size: 1.4rem; font-weight: 700; color: var(--orange); }
    .btn-confirm {
        width: 100%; background: var(--orange); color: #fff;
        border: none; border-radius: 8px; padding: 14px;
        font-weight: 700; font-size: 1rem; cursor: pointer;
        transition: background .2s, transform .15s;
    }
    .btn-confirm:hover {
        background: #e05a26; transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255,107,53,.3);
    }
    .btn-back {
        display: block; text-align: center; margin-top: 12px;
        color: var(--text-muted); font-size: .9rem; text-decoration: none;
    }
    .btn-back:hover { color: var(--primary); }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="confirm-card">
        <div class="confirm-header">
            <h4><i class="fas fa-calendar-check me-2"></i>Confirm Your Appointment</h4>
            <p>Please review the details before confirming</p>
        </div>
        <div class="confirm-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            @endif

            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-user-md me-2 text-primary"></i>Doctor</span>
                <span class="detail-value">{{ $slot->doctor->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-stethoscope me-2 text-primary"></i>Specialization</span>
                <span class="detail-value">{{ $slot->doctor->specialization }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-hospital me-2 text-primary"></i>Clinic</span>
                <span class="detail-value">{{ $slot->clinic->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Address</span>
                <span class="detail-value" style="max-width:280px">{{ $slot->clinic->full_address }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calendar me-2 text-primary"></i>Date</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-clock me-2 text-primary"></i>Time</span>
                <span class="detail-value">{{ $slot->formatted_time }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-tag me-2 text-primary"></i>Visit Type</span>
                <span class="detail-value">{{ $visitType === 'first_visit' ? 'First Visit' : 'Follow Up' }}</span>
            </div>

            @php
                $fees = $slot->clinic->feesDetails()->where('doctor_id', $slot->doctor_id)->first();
                $fee  = $visitType === 'first_visit' ? $fees?->first_visit_fee : $fees?->follow_up_fee;
            @endphp
            @if($fee)
            <div class="fee-highlight d-flex justify-content-between align-items-center">
                <span><i class="fas fa-rupee-sign me-1"></i>Consultation Fee</span>
                <div class="text-end">
                    <div class="amount">₹{{ number_format($fee) }}</div>
                    <div style="font-size:.78rem; color:var(--text-muted)">{{ $fees->payment_mode }}</div>
                </div>
            </div>
            @endif

            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $slot->doctor_id }}">
                <input type="hidden" name="clinic_id"  value="{{ $slot->clinic_id }}">
                <input type="hidden" name="slot_id"    value="{{ $slot->id }}">
                <input type="hidden" name="date"       value="{{ $date }}">
                <input type="hidden" name="visit_type" value="{{ $visitType }}">

                <button type="submit" class="btn-confirm">
                    <i class="fas fa-check me-2"></i>Confirm Appointment
                </button>
            </form>

            <a href="javascript:history.back()" class="btn-back">
                <i class="fas fa-arrow-left me-1"></i>Go back and change
            </a>
        </div>
    </div>
</div>
@endsection
