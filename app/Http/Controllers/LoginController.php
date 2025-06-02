<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Override agar login pakai username, bukan email
    public function username()
    {
        return 'username';
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        return view('login'); // Pastikan file resources/views/login.blade.php tersedia
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            \Log::info('Login berhasil oleh: ' . Auth::user()->username);
            return $this->authenticated($request, Auth::user());
        }

        \Log::warning('Login gagal untuk username: ' . $request->username);

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }

    // Arahkan user setelah login berhasil
    protected function authenticated(Request $request, $user)
    {
        $role = $user->role->role_nama ?? 'null';
        \Log::info('User role: ' . $role);

        if ($role === 'Admin') {
            return redirect('/admin');
        } elseif ($role === 'Alumni') {
            return redirect('/alumni/' . $user->id); // Sesuaikan dengan kebutuhan route alumni
        } else {
            return redirect('/user/dashboard');
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Berhasil logout.');
    }
}
