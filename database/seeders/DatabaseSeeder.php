<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\FeesDetail;
use App\Models\Slot;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Dr. Kapil Shukla
        $doctor = Doctor::create([
            'name'             => 'Dr. Kapil Shukla',
            'slug'             => 'dr-kapil-shukla',
            'phone'            => '8108716370',
            'email'            => 'dr.kapil@example.com',
            'qualification'    => 'MBBS, MD',
            'specialization'   => 'Pediatrician',
            'bio'              => 'Dr. Kapil Shukla is a highly experienced Pediatrician with over 15 years of practice. He specializes in child health, growth disorders, and pediatric infectious diseases.',
            'experience_years' => 15,
            'is_active'        => true,
        ]);

        // Create Clinics
        $clinic1 = Clinic::create([
            'doctor_id' => $doctor->id,
            'name'      => 'Radho Little Steps Pediatrics',
            'address'   => 'Radho\'s Little Steps Pediatrics clinic tata motors hatikesh Hatikesh Udhog Nagar, Konkan Division',
            'city'      => 'Maharashtra',
            'state'     => 'India',
            'pincode'   => '401107',
            'phone'     => '8108716370',
            'is_active' => true,
        ]);

        $clinic2 = Clinic::create([
            'doctor_id' => $doctor->id,
            'name'      => 'City Children\'s Clinic',
            'address'   => '14, Sector 5, Vashi',
            'city'      => 'Navi Mumbai',
            'state'     => 'Maharashtra',
            'pincode'   => '400703',
            'phone'     => '9876543210',
            'is_active' => true,
        ]);

        // Fees for clinic 1
        FeesDetail::create([
            'doctor_id'       => $doctor->id,
            'clinic_id'       => $clinic1->id,
            'first_visit_fee' => 600,
            'follow_up_fee'   => 300,
            'payment_mode'    => 'Pay at Clinic',
        ]);

        // Fees for clinic 2
        FeesDetail::create([
            'doctor_id'       => $doctor->id,
            'clinic_id'       => $clinic2->id,
            'first_visit_fee' => 800,
            'follow_up_fee'   => 400,
            'payment_mode'    => 'Pay at Clinic',
        ]);

        // Time slots for clinic 1 (evening slots: 06:15 PM – 07:15 PM)
        $times = [
            ['06:15:00', '06:30:00'],
            ['06:30:00', '06:45:00'],
            ['06:45:00', '07:00:00'],
            ['07:00:00', '07:15:00'],
            ['07:15:00', '07:30:00'],
        ];

        foreach ($times as [$start, $end]) {
            Slot::create([
                'doctor_id'   => $doctor->id,
                'clinic_id'   => $clinic1->id,
                'start_time'  => $start,
                'end_time'    => $end,
                'day_of_week' => null, // available all days
                'is_active'   => true,
            ]);
        }

        // Morning slots for clinic 2
        $morningTimes = [
            ['10:00:00', '10:15:00'],
            ['10:15:00', '10:30:00'],
            ['10:30:00', '10:45:00'],
            ['10:45:00', '11:00:00'],
            ['11:00:00', '11:15:00'],
            ['11:15:00', '11:30:00'],
        ];

        foreach ($morningTimes as [$start, $end]) {
            Slot::create([
                'doctor_id'   => $doctor->id,
                'clinic_id'   => $clinic2->id,
                'start_time'  => $start,
                'end_time'    => $end,
                'day_of_week' => null,
                'is_active'   => true,
            ]);
        }
    }
}
