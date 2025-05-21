<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        \Log::info('User role: ' . ($user->role->role_nama ?? 'null'));
        $role = $user->role->role_nama;

        if ($role === 'Admin') {
            return redirect('/admin/profesi');
        } elseif ($role === 'Alumni') {
            return redirect('/admin/profesi');
        } else {
            return redirect('/user/dashboard');
        }
    }


    // Tampilkan form login
    public function showLoginForm()
    {
        return view('login'); // Pastikan file resources/views/auth/login.blade.php ada
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
            return $this->authenticated($request, Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
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
