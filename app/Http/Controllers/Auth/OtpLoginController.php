<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\alumniModel;
use App\Models\atasanModel;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OtpLoginController extends Controller
{
    /**
     * Tampilkan form input email
     */
    public function showEmailForm()
    {
        return view('auth.email');
    }

    /**
     * Kirim OTP ke email alumni atau atasan
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        $alumni = alumniModel::where('email', $email)->first();
        $atasan = atasanModel::where('email_atasan', $email)->first();

        if (!$alumni && !$atasan) {
            return back()->withErrors(['email' => 'Email tidak terdaftar sebagai alumni atau atasan.']);
        }

        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['email' => $email],
            ['otp_code' => $otp]
        );

        Mail::to($email)->send(new SendOtpMail($otp));

        session([
            'otp_email' => $email,
            'otp_role' => $alumni ? 'alumni' : 'atasan',
        ]);

        return redirect()->route('otp.verify.form')->with('status', 'OTP telah dikirim ke email.');
    }

    /**
     * Tampilkan form input OTP
     */
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    /**
     * Verifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
        ]);

        $email = session('otp_email');
        $role = session('otp_role');

        $otp = Otp::where('email', $email)
            ->where('otp_code', $request->otp_code)
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kadaluarsa.']);
        }

        // Hapus OTP setelah berhasil login
        $otp->delete();

        // Redirect berdasarkan role
        if ($role === 'alumni') {
            $alumni = alumniModel::where('email', $email)->first();
            session(['alumni_id' => $alumni->id]);
            return redirect()->route('alumni.form', $alumni->alumni_id);
        }

        if ($role === 'atasan') {
            $atasan = atasanModel::where('email', $email)->first();
            session(['atasan_id' => $atasan->id]);
            return redirect()->route('kuisioner', $atasan->id);
        }

        return redirect('/')->withErrors(['login' => 'Role tidak dikenali.']);
    }
}
