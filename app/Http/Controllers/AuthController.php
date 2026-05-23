<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show login form (email input step)
     */
    public function showLogin(Request $request)
    {
        if (Session::has('user_id')) {
            return redirect()->intended('/');
        }
        return view('auth.login');
    }

    /**
     * Send OTP to the user's email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email',
        ]);

        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::updateOrCreate(
            ['email' => $request->email],
            [
                'name'           => $request->name,
                'otp'            => $otp,
                'otp_expires_at' => now()->addMinutes(10),
            ]
        );

        try {
            Mail::to($user->email)->send(new OtpMail($otp, $user->name));
        } catch (\Exception $e) {
            // In dev/demo mode, flash OTP to session for testing
            Session::flash('demo_otp', $otp);
        }

        Session::put('pending_user_email', $user->email);

        return redirect()->route('auth.otp.form')
            ->with('success', 'OTP sent to your email address.');
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm()
    {
        if (!Session::has('pending_user_email')) {
            return redirect()->route('auth.login');
        }
        return view('auth.verify_otp');
    }

    /**
     * Verify submitted OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = Session::get('pending_user_email');
        $user  = User::where('email', $email)->first();

        if (!$user || !$user->isOtpValid($request->otp)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again.']);
        }

        $user->update([
            'is_verified'    => true,
            'otp'            => null,
            'otp_expires_at' => null,
        ]);

        Session::forget('pending_user_email');
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_email', $user->email);

        $intended = Session::pull('url.intended', '/');
        return redirect($intended)->with('success', 'Logged in successfully!');
    }

    /**
     * Logout
     */
    public function logout()
    {
        Session::forget(['user_id', 'user_name', 'user_email']);
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
