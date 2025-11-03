<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CaptchaController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        // Validasi input (unique check akan dilakukan manual)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'captcha' => 'required|numeric',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'captcha.required' => 'Kode captcha wajib diisi.',
            'captcha.numeric' => 'Kode captcha harus berupa angka.',
        ]);

        // Validasi captcha (math question)
        if (!$request->captcha || $request->captcha != session('captcha_answer')) {
            return back()->withErrors([
                'captcha' => 'Jawaban salah. Silakan coba lagi.',
            ])->withInput($request->except('password', 'captcha'));
        }

        // Cek apakah email sudah terdaftar
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            // Jika user sudah aktif, tidak boleh daftar lagi
            if ($existingUser->is_active) {
                return back()->withErrors([
                    'email' => 'Email sudah terdaftar dan terverifikasi. Silakan login.',
                ])->withInput();
            }

            // Jika user belum aktif, hapus data lama agar bisa daftar ulang
            Log::info('Menghapus user lama yang belum verifikasi: ' . $existingUser->email);
            $existingUser->delete();
        }

        // Create user (active immediately - OTP disabled)
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,  // Langsung aktif tanpa OTP
        ];

        // Add username if column exists
        if (Schema::hasColumn('users', 'username')) {
            $userData['username'] = $this->generateUsername($request->email);
        }

        $user = User::create($userData);

        Log::info('=== REGISTRASI USER BARU (OTP DISABLED) ===');
        Log::info('Nama: ' . $user->name);
        Log::info('Email: ' . $user->email);
        Log::info('Status: Langsung Aktif');
        
        // Auto-login user setelah registrasi
        Auth::login($user);
        
        Log::info('User auto-login berhasil');
        Log::info('=== SELESAI PROSES REGISTRASI ===');

        // Langsung redirect ke halaman galeri
        return redirect()->route('home')
            ->with('success', 'Selamat datang, ' . $user->name . '! Registrasi Anda berhasil.');
    }

    /**
     * Show OTP verification form.
     */
    public function showOtpForm()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('register')
                ->with('error', 'Sesi verifikasi tidak valid. Silakan daftar ulang.');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus 6 digit.',
        ]);

        $userId = session('otp_user_id');
        if (!$userId) {
            return back()->withErrors(['otp' => 'Sesi verifikasi tidak valid. Silakan daftar ulang.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return back()->withErrors(['otp' => 'User tidak ditemukan.']);
        }

        // Verify OTP
        if ($user->verifyOtpCode($request->otp)) {
            // Activate user account
            $user->activate();
            
            // Clear session
            session()->forget('otp_user_id');

            return redirect()->route('login')
                ->with('success', 'Akun Anda telah diaktifkan! Silakan login.');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
    }

    /**
     * Resend OTP code.
     */
    public function resendOtp(Request $request)
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return back()->withErrors(['otp' => 'Sesi verifikasi tidak valid.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return back()->withErrors(['otp' => 'User tidak ditemukan.']);
        }

        // Generate new OTP
        $otp = $user->generateOtpCode();

        Log::info('=== KIRIM ULANG OTP ===');
        Log::info('Email: ' . $user->email);
        Log::info('OTP Baru: ' . $otp);
        Log::info('OTP berlaku sampai: ' . $user->otp_expires_at);

        // Send OTP via email
        try {
            Log::info('Mencoba mengirim ulang email OTP ke: ' . $user->email);
            
            Mail::raw(
                "Halo {$user->name},\n\nKode OTP Baru Anda: {$otp}\n\nKode ini berlaku selama 10 menit.\n\nJangan berikan kode ini kepada siapapun.\n\nTerima kasih telah mendaftar di Galeri SMKN 4 Bogor.",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Kode OTP Verifikasi Akun - Galeri SMKN 4 Bogor');
                }
            );
            
            Log::info('✓ Email OTP berhasil dikirim ulang ke: ' . $user->email);
        } catch (\Exception $e) {
            Log::error('✗ GAGAL mengirim ulang OTP email!');
            Log::error('Error: ' . $e->getMessage());
            
            return back()->withErrors([
                'otp' => 'Gagal mengirim email OTP. Error: ' . $e->getMessage()
            ]);
        }

        Log::info('=== SELESAI KIRIM ULANG OTP ===');
        
        return back()->with('success', 'Kode OTP baru telah dikirim ke email ' . $user->email);
    }

    /**
     * Generate unique username from email.
     */
    private function generateUsername(string $email): string
    {
        $username = explode('@', $email)[0];
        $counter = 1;
        
        while (User::where('username', $username)->exists()) {
            $username = explode('@', $email)[0] . $counter;
            $counter++;
        }
        
        return $username;
    }
}
