@extends('layouts.app')

@section('title', $doctor->name . ' - Book Appointment')

@push('styles')
<style>


:root {
    --primary: #00b0b9;
    --orange: #ff6b35;
    --border: #e0e0e0;
    --text-muted: #888;
    --text-dark: #222;
    --light-bg: #f8f9fa;
    --slot-available: #eafaf1;
    --slot-available-border: #27ae60;
    --slot-booked: #f5f5f5;
    --slot-booked-border: #ccc;
}


    /* ── Doctor Profile Card ── */
    .doctor-hero {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 24px 28px;
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }
    .doctor-avatar {
        width: 90px; height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary);
        flex-shrink: 0;
    }
    .doctor-avatar-placeholder {
        width: 90px; height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00b0b9 0%, #008a92 100%);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 2rem;
        flex-shrink: 0;
    }
    .doctor-name { font-size: 1.35rem; font-weight: 700; margin-bottom: 2px; }
    .doctor-qual { color: var(--text-muted); font-size: .88rem; margin-bottom: 4px; }
    .doctor-spec { font-size: .92rem; color: var(--text-dark); font-weight: 500; }
    .btn-view-profile {
        background: var(--orange); color: #fff; border: none;
        padding: 8px 22px; border-radius: 20px; font-weight: 600;
        font-size: .88rem; cursor: pointer; text-decoration: none;
        display: inline-block; margin-top: 8px;
    }
    .btn-view-profile:hover { background: #e05a26; color: #fff; }

    /* ── Booking Section ── */
    .booking-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    .booking-card-header {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border);
    }
    .booking-card-header h5 {
        font-weight: 700; margin: 0; font-size: 1.05rem;
    }
    .fee-info {
        font-size: .82rem; color: #27ae60; font-weight: 500;
    }
    .badge-inclinic {
        background: #e8f8ff; color: var(--primary);
        border: 1px solid #b3e5fc;
        padding: 5px 12px; border-radius: 8px;
        font-size: .8rem; font-weight: 600;
    }
    .booking-card-body { padding: 24px; }

    /* ── Form Labels ── */
    .form-label { font-weight: 600; font-size: .88rem; color: var(--text-dark); margin-bottom: 6px; }
    .form-control, .form-select {
        border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .93rem; padding: 10px 14px;
        transition: border-color .2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0,176,185,.12);
    }
    .clinic-address {
        font-size: .8rem; color: var(--text-muted); margin-top: 6px;
        padding: 8px 12px; background: var(--light-bg);
        border-radius: 6px; border: 1px solid var(--border);
    }

    /* ── Slot Legend ── */
    .slot-legend {
        display: flex; gap: 16px; align-items: center;
        font-size: .82rem; color: var(--text-muted); margin-bottom: 14px;
    }
    .legend-dot {
        width: 14px; height: 14px; border-radius: 3px; display: inline-block; margin-right: 5px;
    }
    .legend-available { background: var(--slot-available); border: 1.5px solid var(--slot-available-border); }
    .legend-booked { background: var(--slot-booked); border: 1.5px solid var(--slot-booked-border); }

    /* ── Slot Buttons ── */
    .slots-grid {
        display: flex; flex-wrap: wrap; gap: 10px;
    }
    .slot-btn {
        padding: 9px 18px;
        border-radius: 8px;
        font-size: .88rem;
        font-weight: 600;
        cursor: pointer;
        border: 2px solid;
        transition: all .18s;
        min-width: 90px;
        text-align: center;
    }
    .slot-btn.available {
        background: var(--slot-available);
        border-color: var(--slot-available-border);
        color: #1d6b3e;
    }
    .slot-btn.available:hover {
        background: #27ae60; color: #fff;
        border-color: #27ae60;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(39,174,96,.25);
    }
    .slot-btn.available.selected {
        background: #27ae60; color: #fff;
        border-color: #27ae60;
        box-shadow: 0 4px 12px rgba(39,174,96,.3);
    }
    .slot-btn.booked {
        background: var(--slot-booked);
        border-color: var(--slot-booked-border);
        color: #aaa;
        cursor: not-allowed;
    }
    .slot-btn.loading { opacity: .5; cursor: wait; }

    /* ── Slot loading indicator ── */
    #slots-loading {
        display: none; color: var(--text-muted); font-size: .88rem; padding: 8px 0;
    }
    #no-slots {
        display: none; color: #c0392b; font-size: .9rem;
    }

    /* ── Continue Button ── */
    .btn-continue {
        background: var(--orange); color: #fff;
        border: none; border-radius: 8px;
        padding: 12px 36px; font-weight: 700;
        font-size: 1rem; cursor: pointer; width: 100%;
        transition: background .2s, transform .15s;
        margin-top: 20px;
    }
    .btn-continue:hover:not(:disabled) {
        background: #e05a26; transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255,107,53,.3);
    }
    .btn-continue:disabled { opacity: .5; cursor: not-allowed; }

    /* ── Visit Type ── */
    .visit-type-group { display: flex; gap: 10px; }
    .visit-type-label {
        flex: 1; border: 2px solid var(--border); border-radius: 8px;
        padding: 10px 14px; cursor: pointer; font-size: .88rem;
        font-weight: 500; text-align: center; transition: all .18s;
    }
    .visit-type-label input { display: none; }
    .visit-type-label:has(input:checked) {
        border-color: var(--primary); background: #e6f9fb; color: var(--primary);
    }
    .visit-type-label:hover { border-color: var(--primary); }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Doctor Hero Card --}}
            <div class="doctor-hero mb-4">
                <div class="doctor-avatar-placeholder">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="doctor-name">{{ $doctor->name }}</div>
                    <div class="doctor-qual">{{ $doctor->qualification }}</div>
                    <div class="doctor-spec">{{ $doctor->specialization }}</div>
                    @if($doctor->experience_years)
                        <div class="text-muted mt-1" style="font-size:.82rem">
                            <i class="fas fa-clock me-1"></i>{{ $doctor->experience_years }} years experience
                        </div>
                    @endif
                    <a href="#" class="btn-view-profile mt-2">View Profile</a>
                </div>
            </div>

            {{-- Booking Card --}}
            <div class="booking-card">
                <div class="booking-card-header d-flex justify-content-between align-items-start">
                    <div>
                        <h5><i class="fas fa-calendar-plus me-2 text-primary"></i>Book Appointment</h5>
                        @if($fees)
                            <div class="fee-info mt-1">
                                First Visit: ₹{{ number_format($fees->first_visit_fee) }} {{ $fees->payment_mode }}
                                &nbsp;|&nbsp;
                                Follow Up: ₹{{ number_format($fees->follow_up_fee) }} {{ $fees->payment_mode }}
                            </div>
                        @endif
                    </div>
                    <span class="badge-inclinic"><i class="fas fa-hospital me-1"></i>In-Clinic</span>
                </div>

                <div class="booking-card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form id="bookingForm" action="{{ route('appointments.create') }}" method="GET">

                        {{-- Clinic Selector --}}
                        <div class="mb-3">
                            <label class="form-label">Clinic Name</label>
                            <select id="clinicSelect" name="clinic_id" class="form-select">
                                @foreach($doctor->clinics as $clinic)
                                    <option value="{{ $clinic->id }}"
                                        data-address="{{ $clinic->full_address }}"
                                        {{ $selectedClinic?->id == $clinic->id ? 'selected' : '' }}>
                                        {{ $clinic->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="clinicAddress" class="clinic-address">
                                {{ $selectedClinic?->full_address }}
                            </div>
                        </div>

                        {{-- Visit Type --}}
                        <div class="mb-3">
                            <label class="form-label">Visit Type</label>
                            <div class="visit-type-group">
                                <label class="visit-type-label">
                                    <input type="radio" name="visit_type" value="first_visit" checked>
                                    <i class="fas fa-user-plus me-1"></i>First Visit
                                    @if($fees) <br><small>₹{{ number_format($fees->first_visit_fee) }}</small> @endif
                                </label>
                                <label class="visit-type-label">
                                    <input type="radio" name="visit_type" value="follow_up">
                                    <i class="fas fa-redo me-1"></i>Follow Up
                                    @if($fees) <br><small>₹{{ number_format($fees->follow_up_fee) }}</small> @endif
                                </label>
                            </div>
                        </div>

                        {{-- Date Picker --}}
                        <div class="mb-3">
                            <label class="form-label">Appointment Date</label>
                            <input type="date" id="dateInput" name="date" class="form-control"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ date('Y-m-d') }}">
                        </div>

                        {{-- Slots --}}
                        <div class="mb-3">
                            <label class="form-label">Available Slots</label>
                            <div class="slot-legend">
                                <span><span class="legend-dot legend-available"></span>Available</span>
                                <span><span class="legend-dot legend-booked"></span>Booked</span>
                            </div>
                            <div id="slots-loading"><i class="fas fa-spinner fa-spin me-1"></i>Loading slots…</div>
                            <div id="no-slots">No slots available for this date.</div>
                            <div id="slotsGrid" class="slots-grid"></div>
                            <input type="hidden" id="selectedSlot" name="slot_id" value="">
                        </div>

                        {{-- Hidden fields --}}
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                        {{-- Continue Button --}}
                        <button type="submit" id="continueBtn" class="btn-continue" disabled>
                            <i class="fas fa-arrow-right me-2"></i>Continue
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const DOCTOR_ID  = {{ $doctor->id }};
const SLOTS_URL  = "{{ route('api.slots') }}";

const clinicSelect  = document.getElementById('clinicSelect');
const dateInput     = document.getElementById('dateInput');
const slotsGrid     = document.getElementById('slotsGrid');
const selectedSlot  = document.getElementById('selectedSlot');
const continueBtn   = document.getElementById('continueBtn');
const clinicAddress = document.getElementById('clinicAddress');
const slotsLoading  = document.getElementById('slots-loading');
const noSlots       = document.getElementById('no-slots');

function getSelectedClinicId() {
    return clinicSelect.value;
}

// Update clinic address label when dropdown changes
clinicSelect.addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    clinicAddress.textContent = opt.dataset.address || '';
    fetchSlots();
});

dateInput.addEventListener('change', fetchSlots);

function fetchSlots() {
    const clinicId = getSelectedClinicId();
    const date     = dateInput.value;
    if (!clinicId || !date) return;

    slotsGrid.innerHTML = '';
    selectedSlot.value  = '';
    continueBtn.disabled = true;
    slotsLoading.style.display = 'block';
    noSlots.style.display = 'none';

    fetch(`${SLOTS_URL}?doctor_id=${DOCTOR_ID}&clinic_id=${clinicId}&date=${date}`)
        .then(r => r.json())
        .then(data => {
            slotsLoading.style.display = 'none';
            if (!data.slots || data.slots.length === 0) {
                noSlots.style.display = 'block';
                return;
            }
            data.slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `slot-btn ${slot.is_booked ? 'booked' : 'available'}`;
                btn.textContent = slot.time;
                btn.dataset.slotId = slot.id;
                if (!slot.is_booked) {
                    btn.addEventListener('click', () => selectSlot(btn, slot.id));
                }
                slotsGrid.appendChild(btn);
            });
        })
        .catch(() => {
            slotsLoading.style.display = 'none';
            noSlots.textContent = 'Error loading slots. Please try again.';
            noSlots.style.display = 'block';
        });
}

function selectSlot(btn, slotId) {
    // Deselect all
    document.querySelectorAll('.slot-btn.available').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    selectedSlot.value    = slotId;
    continueBtn.disabled  = false;
}

// Initial load
fetchSlots();
</script>
@endpush
