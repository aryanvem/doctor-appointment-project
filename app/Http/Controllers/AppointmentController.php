<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirmationMail;
use App\Models\Appointment;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    /**
     * Show booking confirmation page (slot selected, logged in user)
     */
    public function create(Request $request)
    {
        $request->validate([
            'doctor_id'   => 'required|exists:doctors,id',
            'clinic_id'   => 'required|exists:clinics,id',
            'slot_id'     => 'required|exists:slots,id',
            'date'        => 'required|date|after_or_equal:today',
            'visit_type'  => 'required|in:first_visit,follow_up',
        ]);

        if (!Session::has('user_id')) {
            Session::put('url.intended', url()->full());
            // Store booking intent in session so it survives login
            Session::put('booking_intent', $request->only(
                'doctor_id', 'clinic_id', 'slot_id', 'date', 'visit_type'
            ));
            return redirect()->route('auth.login')
                ->with('info', 'Please login to book your appointment.');
        }

        $slot = Slot::with(['doctor', 'clinic'])->findOrFail($request->slot_id);

        // Check slot is still available
        if ($slot->isBookedOn($request->date)) {
            return back()->withErrors(['slot_id' => 'This slot is already booked. Please choose another.']);
        }

        return view('appointments.confirm', [
            'slot'      => $slot,
            'date'      => $request->date,
            'visitType' => $request->visit_type,
        ]);
    }

    /**
     * Store the appointment
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'   => 'required|exists:doctors,id',
            'clinic_id'   => 'required|exists:clinics,id',
            'slot_id'     => 'required|exists:slots,id',
            'date'        => 'required|date|after_or_equal:today',
            'visit_type'  => 'required|in:first_visit,follow_up',
        ]);

        if (!Session::has('user_id')) {
            return redirect()->route('auth.login');
        }

        $slot = Slot::findOrFail($request->slot_id);

        if ($slot->isBookedOn($request->date)) {
            return back()->withErrors(['slot_id' => 'Slot just got booked. Please choose another.']);
        }

        $appointment = Appointment::create([
            'user_id'          => Session::get('user_id'),
            'doctor_id'        => $request->doctor_id,
            'clinic_id'        => $request->clinic_id,
            'slot_id'          => $request->slot_id,
            'appointment_date' => $request->date,
            'appointment_type' => $request->visit_type,
            'status'           => 'booked',
            'booking_ref'      => strtoupper(Str::random(8)),
        ]);

        $appointment->load(['doctor', 'clinic', 'slot', 'user']);

        try {
            Mail::to($appointment->user->email)
                ->send(new AppointmentConfirmationMail($appointment));
        } catch (\Exception $e) {
            // Mail failure should not block booking
        }

        Session::forget('booking_intent');

        return redirect()->route('appointments.success', $appointment->id);
    }

    /**
     * Show success page
     */
    public function success(Appointment $appointment)
    {
        if ($appointment->user_id !== Session::get('user_id')) {
            abort(403);
        }
        $appointment->load(['doctor', 'clinic', 'slot']);
        return view('appointments.success', compact('appointment'));
    }

    /**
     * List user appointments
     */
    public function index()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('auth.login');
        }

        $appointments = Appointment::where('user_id', Session::get('user_id'))
            ->with(['doctor', 'clinic', 'slot'])
            ->orderByDesc('appointment_date')
            ->get();

        return view('appointments.index', compact('appointments'));
    }
}
