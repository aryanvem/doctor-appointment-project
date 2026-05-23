<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmed</title>
</head>
<body style="margin:0;padding:0;background:#f0f4ff;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px;">
<tr><td align="center">
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;">

    <!-- TOP LOGO BAR -->
    <tr>
        <td style="padding-bottom:20px;text-align:center;">
            <div style="display:inline-block;background:#fff;border-radius:50px;padding:10px 28px;box-shadow:0 2px 12px rgba(58,123,213,.12);">
                <span style="font-size:1.3rem;font-weight:900;color:#3a7bd5;letter-spacing:-0.5px;">🩺 DoctorsApp</span>
            </div>
        </td>
    </tr>

    <!-- HERO CARD -->
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:24px;overflow:hidden;box-shadow:0 8px 40px rgba(58,123,213,.13);">

                <!-- GRADIENT HEADER -->
                <tr>
                    <td style="background:linear-gradient(135deg,#1a2f6e 0%,#3a7bd5 50%,#5b9ef5 100%);padding:48px 40px 36px;text-align:center;position:relative;">
                        <!-- Checkmark circle -->
                        <div style="width:80px;height:80px;background:rgba(255,255,255,.15);border:3px solid rgba(255,255,255,.4);border-radius:50%;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;">
                            <div style="width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,.2);text-align:center;line-height:80px;font-size:2.2rem;">✅</div>
                        </div>
                        <h1 style="color:#fff;font-size:1.8rem;font-weight:900;margin:0 0 8px;letter-spacing:-.5px;">Appointment Confirmed!</h1>
                        <p style="color:rgba(255,255,255,.8);margin:0;font-size:.95rem;font-weight:600;">Your booking has been successfully placed</p>

                        <!-- Booking ref badge -->
                        <div style="display:inline-block;margin-top:20px;background:rgba(255,255,255,.15);border:2px dashed rgba(255,255,255,.5);border-radius:12px;padding:10px 28px;">
                            <div style="color:rgba(255,255,255,.7);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;margin-bottom:4px;">Booking Reference</div>
                            <div style="color:#fff;font-size:1.4rem;font-weight:900;letter-spacing:4px;font-family:monospace;">{{ $appointment->booking_ref }}</div>
                        </div>
                    </td>
                </tr>

                <!-- GREETING -->
                <tr>
                    <td style="padding:32px 40px 0;">
                        <p style="font-size:1rem;color:#1a2540;margin:0;font-weight:700;">
                            Hi <span style="color:#3a7bd5;">{{ $appointment->user->name }}</span>,
                        </p>
                        <p style="font-size:.9rem;color:#6b7fa3;margin:8px 0 0;line-height:1.6;font-weight:600;">
                            Great news! Your appointment has been confirmed. Here's everything you need to know:
                        </p>
                    </td>
                </tr>

                <!-- APPOINTMENT DETAILS CARD -->
                <tr>
                    <td style="padding:24px 40px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f7f9ff;border-radius:16px;overflow:hidden;border:1.5px solid #e8edf6;">

                            <!-- Section title -->
                            <tr>
                                <td colspan="2" style="background:linear-gradient(90deg,#3a7bd5,#5b9ef5);padding:12px 20px;">
                                    <span style="color:#fff;font-size:.8rem;font-weight:900;text-transform:uppercase;letter-spacing:.08em;">📋 Appointment Details</span>
                                </td>
                            </tr>

                            <!-- Doctor -->
                            <tr>
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;width:40%;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <span style="font-size:1.1rem;">👨‍⚕️</span>
                                        <span style="font-size:.8rem;font-weight:800;color:#6b7fa3;text-transform:uppercase;letter-spacing:.05em;">Doctor</span>
                                    </div>
                                </td>
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <div style="font-size:.95rem;font-weight:800;color:#1a2540;">{{ $appointment->doctor->name }}</div>
                                    <div style="font-size:.78rem;color:#3a7bd5;font-weight:700;margin-top:2px;">{{ $appointment->doctor->qualification }} &bull; {{ $appointment->doctor->specialization }}</div>
                                </td>
                            </tr>

                            <!-- Clinic -->
                            <tr style="background:#fff;">
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <span style="font-size:1.1rem;">🏥</span>
                                        <span style="font-size:.8rem;font-weight:800;color:#6b7fa3;text-transform:uppercase;letter-spacing:.05em;">Clinic</span>
                                    </div>
                                </td>
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <div style="font-size:.95rem;font-weight:800;color:#1a2540;">{{ $appointment->clinic->name }}</div>
                                    <div style="font-size:.78rem;color:#6b7fa3;font-weight:600;margin-top:2px;">{{ $appointment->clinic->full_address }}</div>
                                </td>
                            </tr>

                            <!-- Date -->
                            <tr>
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <span style="font-size:1.1rem;">📅</span>
                                        <span style="font-size:.8rem;font-weight:800;color:#6b7fa3;text-transform:uppercase;letter-spacing:.05em;">Date</span>
                                    </div>
                                </td>
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <div style="font-size:.95rem;font-weight:800;color:#1a2540;">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, d F Y') }}
                                    </div>
                                </td>
                            </tr>

                            <!-- Time -->
                            <tr style="background:#fff;">
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <span style="font-size:1.1rem;">⏰</span>
                                        <span style="font-size:.8rem;font-weight:800;color:#6b7fa3;text-transform:uppercase;letter-spacing:.05em;">Time</span>
                                    </div>
                                </td>
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <div style="font-size:.95rem;font-weight:800;color:#1a2540;">{{ $appointment->slot->formatted_time }}</div>
                                </td>
                            </tr>

                            <!-- Visit Type -->
                            <tr>
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <span style="font-size:1.1rem;">🏷️</span>
                                        <span style="font-size:.8rem;font-weight:800;color:#6b7fa3;text-transform:uppercase;letter-spacing:.05em;">Visit Type</span>
                                    </div>
                                </td>
                                <td style="padding:14px 20px;border-bottom:1px solid #e8edf6;">
                                    <span style="display:inline-block;background:#e8f8f0;color:#27ae60;border:1px solid #a9dfbf;border-radius:20px;padding:4px 14px;font-size:.82rem;font-weight:800;">
                                        {{ $appointment->appointment_type === 'first_visit' ? '🌟 First Visit' : '🔄 Follow Up' }}
                                    </span>
                                </td>
                            </tr>

                            <!-- Fee -->
                            @php
                                $fees = $appointment->clinic->feesDetails()->where('doctor_id', $appointment->doctor_id)->first();
                                $fee  = $appointment->appointment_type === 'first_visit' ? $fees?->first_visit_fee : $fees?->follow_up_fee;
                            @endphp
                            @if($fee)
                            <tr style="background:#fff;">
                                <td style="padding:14px 20px;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <span style="font-size:1.1rem;">💰</span>
                                        <span style="font-size:.8rem;font-weight:800;color:#6b7fa3;text-transform:uppercase;letter-spacing:.05em;">Fee</span>
                                    </div>
                                </td>
                                <td style="padding:14px 20px;">
                                    <div style="font-size:1.1rem;font-weight:900;color:#ff6b35;">₹{{ number_format($fee) }}</div>
                                    <div style="font-size:.75rem;color:#6b7fa3;font-weight:600;margin-top:2px;">{{ $fees->payment_mode }}</div>
                                </td>
                            </tr>
                            @endif

                        </table>
                    </td>
                </tr>

                <!-- REMINDER BOX -->
                <tr>
                    <td style="padding:0 40px 24px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#fff8f0,#fff3e8);border:1.5px solid #ffd166;border-radius:14px;overflow:hidden;">
                            <tr>
                                <td style="padding:18px 20px;">
                                    <div style="font-size:.85rem;font-weight:900;color:#e67e22;margin-bottom:10px;">⚡ Important Reminders</div>
                                    <table cellpadding="0" cellspacing="0">
                                        <tr><td style="padding:4px 0;font-size:.83rem;color:#7d5a1e;font-weight:700;">✓ &nbsp;Arrive 10 minutes before your scheduled time</td></tr>
                                        <tr><td style="padding:4px 0;font-size:.83rem;color:#7d5a1e;font-weight:700;">✓ &nbsp;Carry a valid ID proof</td></tr>
                                        <tr><td style="padding:4px 0;font-size:.83rem;color:#7d5a1e;font-weight:700;">✓ &nbsp;Bring any previous prescriptions or reports</td></tr>
                                        <tr><td style="padding:4px 0;font-size:.83rem;color:#7d5a1e;font-weight:700;">✓ &nbsp;Save your booking ref: <span style="font-family:monospace;font-weight:900;color:#e67e22;letter-spacing:2px;">{{ $appointment->booking_ref }}</span></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- CONTACT / CLINIC INFO -->
                @if($appointment->clinic->phone)
                <tr>
                    <td style="padding:0 40px 24px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4ff;border-radius:14px;border:1.5px solid #dde8ff;">
                            <tr>
                                <td style="padding:16px 20px;">
                                    <div style="font-size:.82rem;font-weight:900;color:#3a7bd5;margin-bottom:6px;">📞 Clinic Contact</div>
                                    <div style="font-size:.88rem;font-weight:700;color:#1a2540;">{{ $appointment->clinic->name }}</div>
                                    <div style="font-size:.83rem;color:#6b7fa3;font-weight:600;margin-top:2px;">{{ $appointment->clinic->phone }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @endif

                <!-- CTA BUTTON -->
                <tr>
                    <td style="padding:0 40px 36px;text-align:center;">
                        <a href="{{ url('/my-appointments') }}"
                           style="display:inline-block;background:linear-gradient(135deg,#ff6b35,#e84e1b);color:#fff;text-decoration:none;padding:14px 40px;border-radius:50px;font-size:.95rem;font-weight:900;letter-spacing:.03em;box-shadow:0 6px 20px rgba(255,107,53,.35);">
                            View My Appointments →
                        </a>
                    </td>
                </tr>

            </table>
        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="padding:24px 0;text-align:center;">
            <p style="font-size:.78rem;color:#a0aec0;margin:0 0 6px;font-weight:600;">
                This is an automated email from DoctorsApp. Please do not reply.
            </p>
            <p style="font-size:.78rem;color:#a0aec0;margin:0;font-weight:600;">
                &copy; {{ date('Y') }} DoctorsApp &bull; Online Appointment System
            </p>
            <div style="margin-top:12px;">
                <span style="display:inline-block;width:6px;height:6px;background:#3a7bd5;border-radius:50;margin:0 3px;"></span>
                <span style="display:inline-block;width:6px;height:6px;background:#ff6b35;border-radius:50;margin:0 3px;"></span>
                <span style="display:inline-block;width:6px;height:6px;background:#ffd166;border-radius:50;margin:0 3px;"></span>
            </div>
        </td>
    </tr>

</table>
</td></tr>
</table>

</body>
</html>
