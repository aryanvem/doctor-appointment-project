<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Slot;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Show the doctor's appointment booking page
     */
    public function show(Request $request, string $slug, string $phone)
{
    $doctor = Doctor::where('slug', $slug)
        ->where('is_active', true)
        ->with(['clinics' => function ($q) {
            $q->where('is_active', true);
        }])
        ->firstOrFail();

    $selectedClinicId = $request->get('clinic_id', $doctor->clinics->first()?->id);
    $selectedClinic   = $doctor->clinics->where('id', $selectedClinicId)->first()
        ?? $doctor->clinics->first();

    $fees = null;
    if ($selectedClinic) {
        $fees = $doctor->feesDetails()
            ->where('clinic_id', $selectedClinic->id)
            ->first();
    }

    return view('doctor.show', compact('doctor', 'selectedClinic', 'fees'));
}

    /**
     * AJAX: Return available slots for a given clinic + date
     */
    public function slots(Request $request)
    {
        $request->validate([
            'doctor_id'  => 'required|exists:doctors,id',
            'clinic_id'  => 'required|exists:clinics,id',
            'date'       => 'required|date|after_or_equal:today',
        ]);

        $date      = $request->date;
        $dayOfWeek = date('w', strtotime($date)); // 0=Sun … 6=Sat

        $slots = Slot::where('doctor_id', $request->doctor_id)
            ->where('clinic_id', $request->clinic_id)
            ->where('is_active', true)
            ->where(function ($q) use ($dayOfWeek) {
                $q->whereNull('day_of_week')
                  ->orWhere('day_of_week', $dayOfWeek);
            })
            ->orderBy('start_time')
            ->get()
            ->map(function (Slot $slot) use ($date) {
                return [
                    'id'         => $slot->id,
                    'time'       => $slot->formatted_time,
                    'start_time' => $slot->start_time,
                    'is_booked'  => $slot->isBookedOn($date),
                ];
            });

        return response()->json(['slots' => $slots]);
    }
}
