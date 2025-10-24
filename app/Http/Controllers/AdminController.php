<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\Post;
use App\Models\Kategori;
use App\Models\Galery;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Show the application login form.
     *
     * @return \Illuminate\View\View
     */
    /**
     * Show the application login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (str_contains(request()->path(), 'admin')) {
            return view('admin.login');
        }
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return $this->showLoginForm();
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $isAdminLogin = str_contains($request->path(), 'admin');

        if ($isAdminLogin) {
            // Admin uses username + password
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
            $credentials = $request->only('username', 'password');
            $guard = 'admin';
            $user = Petugas::where('username', $request->username)->first();
        } else {
            // Public user uses email + password
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $credentials = $request->only('email', 'password');
            $guard = 'web';
            $user = \App\Models\User::where('email', $request->email)->first();
        }

        if (!$user) {
            return back()->withErrors([
                $isAdminLogin ? 'username' : 'email' => 'Akun tidak ditemukan atau kredensial salah.',
            ])->withInput($request->except('password'));
        }

        if (isset($user->status) && $user->status !== 'Aktif') {
            return back()->withErrors([
                $isAdminLogin ? 'username' : 'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ])->withInput($request->except('password'));
        }

        // Handle legacy plaintext admin password then upgrade to bcrypt
        if ($isAdminLogin && $user instanceof \App\Models\Petugas) {
            if (!empty($user->password) && !str_starts_with($user->password, '$2y$') && $user->password === $request->password) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
        }

        if (auth()->guard($guard)->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Keep legacy session keys used by dashboard/profile
            if ($isAdminLogin) {
                Session::put('admin_id', $user->id);
                if (isset($user->username)) {
                    Session::put('admin_username', $user->username);
                }
            }

            return redirect()->intended($isAdminLogin ? route('admin.dashboard') : '/galeri');
        }

        return back()->withErrors([
            $isAdminLogin ? 'username' : 'email' => 'Kredensial salah.',
        ])->withInput($request->except('password'));
    }

    public function dashboard()
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login');
        }

        // Statistik utama
        $totalPosts = Post::count();
        $totalKategoris = Kategori::count();
        $totalGaleries = Galery::count();
        $totalFotos = Foto::count();
        $totalPetugas = Petugas::count();
        $totalInformasi = \App\Models\Informasi::count();

        // Statistik kategori
        $kategorisAktif = Kategori::where('status', 'Aktif')->count();
        $kategorisNonaktif = Kategori::where('status', 'Nonaktif')->count();

        // Statistik foto per kategori
        $fotoPerKategori = Kategori::withCount('fotos')->orderBy('fotos_count', 'desc')->take(5)->get();

        // Data terbaru
        $recentPosts = Post::latest()->take(5)->get();
        $recentFotos = Foto::with('kategori')->latest()->take(6)->get();
        // Treat posts under kategori "Agenda Sekolah" as agendas
        $agendaKategori = Kategori::where('nama', 'Agenda Sekolah')->first();
        $recentAgendas = $agendaKategori
            ? Post::where('kategori_id', $agendaKategori->id)->latest()->take(5)->get()
            : collect();
        $totalAgendas = $agendaKategori
            ? Post::where('kategori_id', $agendaKategori->id)->count()
            : 0;

        // Statistik bulanan (foto yang diupload bulan ini)
        $fotosBulanIni = Foto::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        // Kategori paling populer
        $kategoriPopuler = Kategori::withCount('fotos')
                                 ->orderBy('fotos_count', 'desc')
                                 ->first();

        return view('admin.dashboard', compact(
            'totalPosts', 'totalKategoris', 'totalGaleries', 'totalFotos', 
            'totalPetugas', 'totalAgendas', 'totalInformasi',
            'kategorisAktif', 'kategorisNonaktif', 'fotoPerKategori',
            'recentPosts', 'recentFotos', 'recentAgendas',
            'fotosBulanIni', 'kategoriPopuler'
        ));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $isAdmin = str_contains($request->path(), 'admin');
        $guard = $isAdmin ? 'admin' : 'web';
        
        auth()->guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // After admin logout, go to admin login page
        return redirect()->route('admin.login');
    }

    public function profile()
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $petugas = Petugas::find(Session::get('admin_id'));
        return view('admin.profile', compact('petugas'));
    }

    public function updateProfile(Request $request)
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'username' => 'required|unique:petugas,username,' . Session::get('admin_id'),
            'password' => 'nullable|min:6'
        ]);

        $petugas = Petugas::find(Session::get('admin_id'));
        $petugas->username = $request->username;
        
        if ($request->password) {
            $petugas->password = Hash::make($request->password);
        }
        
        $petugas->save();

        Session::put('admin_username', $petugas->username);

        return back()->with('success', 'Profile berhasil diperbarui');
    }
}

