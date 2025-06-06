<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\alumniModel;
use App\Models\atasanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtpLoginController extends Controller
{
    /**
     * Tampilkan form input email.
     */
    public function showEmailForm()
    {
        return view('auth.email');
    }

    /**
     * Kirim OTP ke email alumni atau atasan.
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        $alumni = alumniModel::where('email', $email)->where('isOtp', false)->first();
        $atasan = atasanModel::where('email_atasan', $email)->where('isOtp', false)->first();

        if (!$alumni && !$atasan) {
            return back()->withErrors(['email' => 'Email tidak terdaftar sebagai alumni atau atasan.']);
        }

        $otp = rand(100000, 999999);

        if ($alumni) {
            $alumni->otp_code = $otp;
            $alumni->save();
        }

        if ($atasan) {
            $atasan->otp_code = $otp;
            $atasan->save();
        }

        Mail::to($email)->send(new SendOtpMail($otp));

        session([
            'otp_email' => $email,
            'otp_role' => $alumni ? 'alumni' : 'atasan',
        ]);

        return redirect()->route('otp.verify.form')->with('status', 'OTP telah dikirim ke email.');
    }

    /**
     * Tampilkan form input OTP.
     */
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    /**
     * Verifikasi OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
        ]);

        $email = session('otp_email');
        $role = session('otp_role');

        if (!$email || !$role) {
            return redirect()->route('otp.email.form')->withErrors(['email' => 'Session expired. Silakan kirim ulang OTP.']);
        }

        if ($role === 'alumni') {
            $alumni = alumniModel::where('email', $email)
                ->where('otp_code', $request->otp_code)
                ->where('isOtp', false)
                ->first();

            if ($alumni) {
                $alumni->isOtp = true;
                $alumni->save();

                // Login alumni menggunakan guard 'alumni'
                Auth::guard('alumni')->login($alumni);

                // Simpan session jika perlu
                session(['alumni_id' => $alumni->alumni_id]);

                return redirect()->route('alumni.form', $alumni->alumni_id);
            }
        }

        if ($role === 'atasan') {
            $atasan = atasanModel::where('email_atasan', $email)
                ->where('otp_code', $request->otp_code)
                ->where('isOtp', false)
                ->first();

            if ($atasan) {
                $atasan->isOtp = true;
                $atasan->save();

                Auth::guard('atasan')->login($atasan);

                session(['atasan_id' => $atasan->atasan_id]);

                return redirect()->route('kuisioner', $atasan->atasan_id);
            }
        }

        return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah tidak berlaku.']);
    }
}
