<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|numeric',
        ], [
            'captcha.required' => 'Kode captcha wajib diisi.',
            'captcha.numeric' => 'Kode captcha harus berupa angka.',
        ]);

        // Validasi captcha (math question)
        if (!$request->captcha || $request->captcha != session('captcha_answer')) {
            return back()->withErrors([
                'captcha' => 'Jawaban salah. Silakan coba lagi.',
            ])->withInput($request->except('password', 'captcha'));
        }

        $credentials = $request->only('email', 'password');
        $isAdminLogin = $request->is('admin/*');
        $guard = $isAdminLogin ? 'admin' : 'web';

        if ($isAdminLogin) {
            $user = Petugas::where('email', $credentials['email'])->first();
        } else {
            $user = User::where('email', $credentials['email'])->first();
        }

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->except('password'));
        }

        // OTP verification disabled - no need to check is_active for regular users
        // if (!$isAdminLogin && isset($user->is_active) && !$user->is_active) {
        //     return back()->withErrors([
        //         'email' => 'Akun Anda belum diverifikasi. Silakan cek email untuk kode OTP.',
        //     ])->withInput($request->except('password'));
        // }

        // Check if the account status is active (for admin users only)
        if ($isAdminLogin && isset($user->status) && $user->status !== 'Aktif') {
            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ])->withInput($request->except('password'));
        }

        // Handle legacy password format for admin users
        if ($isAdminLogin && $user instanceof Petugas) {
            if (!empty($user->password) && !str_starts_with($user->password, '$2y$') && $user->password === $request->password) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
        }

        if (Auth::guard($guard)->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return $isAdminLogin 
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended('/galeri');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $isAdmin = $request->is('admin/*');
        $guard = $isAdmin ? 'admin' : 'web';
        
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $isAdmin 
            ? redirect()->route('admin.login')
            : redirect('/');
    }
}
