<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Post;
use App\Models\Galery;
use App\Models\Foto;
use App\Models\Profile;
use App\Models\Informasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest posts (no more category filtering)
        $informasiTerkini = Post::latest()->take(5)->get();



        // Latest active photos for homepage gallery
        $fotosTerbaru = Foto::where('status', 'Aktif')
            ->orderBy('created_at', 'desc')
            ->take(9)
            ->get();


        // Get school profile information
        $profile = Profile::first();

        // Get all categories for navigation
        $kategoris = Kategori::all();

        return view('home', compact('informasiTerkini', 'fotosTerbaru', 'profile', 'kategoris'));
    }

    public function profil()
    {
        $profile = Profile::first();
        $kategoris = Kategori::all();
        
        return view('profil', compact('profile', 'kategoris'));
    }

    public function galeri(Request $request)
    {
        $query = Foto::with(['kategori', 'likes'])
            ->withCount(['comments as comments_count' => function($query) {
                $query->where('status', 'approved');
            }])
            ->where('status', 'Aktif');

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori) {
            $kategoriSlug = $request->kategori;
            
            // Cari kategori berdasarkan slug yang dibuat dari nama
            $kategori = Kategori::where('status', 'Aktif')->get()->first(function($k) use ($kategoriSlug) {
                $kategoriSlugFromName = strtolower(str_replace([' ', '&'], ['', ''], $k->nama));
                return $kategoriSlugFromName === $kategoriSlug;
            });
            
            if ($kategori) {
                $query->where('kategori_id', $kategori->id);
            }
        }

        $fotos = $query->orderBy('created_at', 'desc')->get();
        
        // Ambil hanya kategori yang memiliki foto aktif untuk filter
        $kategoris = Kategori::where('status', 'Aktif')
            ->whereHas('fotos', function($q) {
                $q->where('status', 'Aktif');
            })
            ->orderBy('nama', 'asc')
            ->get();

        return view('galeri', compact('fotos', 'kategoris'));
    }

    public function kategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        // Since posts no longer have kategori_id, we'll show all posts
        $posts = Post::latest()->paginate(10);

        $kategoris = Kategori::all();

        return view('kategori', compact('kategori', 'posts', 'kategoris'));
    }


    public function jurusan($slug)
    {
        $jurusanData = [
            'pplg' => [
                'nama' => 'PPLG',
                'nama_lengkap' => 'Pengembangan Perangkat Lunak dan Gim',
                'foto' => 'images/jurusan/pplg.jpeg',

                'icon' => 'fas fa-laptop-code',
                'warna' => 'primary',
                'deskripsi' => 'Jurusan PPLG (Pengembangan Perangkat Lunak dan Gim) adalah jurusan yang mempelajari tentang pengembangan aplikasi, website, dan game. Siswa akan diajarkan berbagai bahasa pemrograman dan teknologi terkini.',
                'kompetensi' => [
                    'Pengembangan Aplikasi Web',
                    'Pengembangan Aplikasi Mobile',
                    'Pengembangan Game',
                    'Database Management',
                    'UI/UX Design',
                    'Software Testing'
                ],
                'prospek_kerja' => [
                    'Software Developer',
                    'Web Developer',
                    'Mobile App Developer',
                    'Game Developer',
                    'UI/UX Designer',
                    'Database Administrator'
                ],
                'fasilitas' => [
                    'Lab Komputer Modern',
                    'Software Development Tools',
                    'Game Development Studio',
                    'Internet High Speed',
                    'Projector & Audio System'
                ]
            ],
            'tjkt' => [
                'nama' => 'TJKT',
                'nama_lengkap' => 'Teknik Jaringan Komputer dan Telekomunikasi',
                'foto' => 'images/jurusan/tjkt.jpeg',

                'icon' => 'fas fa-network-wired',
                'warna' => 'success',
                'deskripsi' => 'Jurusan TJKT (Teknik Jaringan Komputer dan Telekomunikasi) mempelajari tentang jaringan komputer, sistem komunikasi, dan teknologi telekomunikasi. Fokus pada infrastruktur jaringan dan keamanan sistem.',
                'kompetensi' => [
                    'Instalasi Jaringan Komputer',
                    'Konfigurasi Router & Switch',
                    'Keamanan Jaringan',
                    'Sistem Operasi Jaringan',
                    'Troubleshooting Jaringan',
                    'Wireless Network'
                ],
                'prospek_kerja' => [
                    'Network Administrator',
                    'System Administrator',
                    'IT Support',
                    'Network Engineer',
                    'Security Analyst',
                    'Telecommunication Engineer'
                ],
                'fasilitas' => [
                    'Lab Jaringan Komputer',
                    'Router & Switch Cisco',
                    'Server Room',
                    'Network Monitoring Tools',
                    'Cable Testing Equipment'
                ]
            ],
            'to' => [
                'nama' => 'TO',
                'nama_lengkap' => 'Teknik Otomotif',
                'foto' => 'images/jurusan/to.jpeg',

                'icon' => 'fas fa-cogs',
                'warna' => 'info',
                'deskripsi' => 'Jurusan TO (Teknik Otomotif) mempelajari tentang mesin kendaraan, sistem kelistrikan, dan perawatan kendaraan. Siswa akan diajarkan teknologi otomotif modern dan sistem kendaraan hybrid/elektrik.',
                'kompetensi' => [
                    'Perbaikan Mesin Kendaraan',
                    'Sistem Kelistrikan Otomotif',
                    'Sistem Transmisi',
                    'Sistem Rem & Suspensi',
                    'Diagnosis Kendaraan',
                    'Perawatan Berkala'
                ],
                'prospek_kerja' => [
                    'Automotive Technician',
                    'Service Advisor',
                    'Parts Specialist',
                    'Quality Control',
                    'Automotive Engineer',
                    'Workshop Manager'
                ],
                'fasilitas' => [
                    'Bengkel Otomotif',
                    'Mesin Kendaraan',
                    'Alat Diagnostik',
                    'Lift Kendaraan',
                    'Spare Parts'
                ]
            ],
            'tpfl' => [
                'nama' => 'TPFL',
                'nama_lengkap' => 'Teknik Pengelasan dan Fabrikasi Logam',
                'foto' => 'images/logo-tpfl.png',

                'icon' => 'fas fa-industry',
                'warna' => 'warning',
                'deskripsi' => 'Jurusan TPFL (Teknik Pengelasan dan Fabrikasi Logam) mempelajari tentang teknik pengelasan, fabrikasi logam, dan konstruksi baja. Fokus pada keterampilan praktis dalam industri manufaktur.',
                'kompetensi' => [
                    'Teknik Pengelasan SMAW',
                    'Teknik Pengelasan GMAW',
                    'Fabrikasi Logam',
                    'Membaca Gambar Teknik',
                    'Keselamatan Kerja',
                    'Quality Control'
                ],
                'prospek_kerja' => [
                    'Welder',
                    'Fabricator',
                    'Quality Inspector',
                    'Production Supervisor',
                    'Maintenance Technician',
                    'Construction Worker'
                ],
                'fasilitas' => [
                    'Workshop Pengelasan',
                    'Mesin Las Modern',
                    'Alat Fabrikasi',
                    'Safety Equipment',
                    'Material Logam'
                ]
            ]
        ];

        if (!isset($jurusanData[$slug])) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Jurusan tidak ditemukan'], 404);
            }
            abort(404);
        }

        $jurusan = $jurusanData[$slug];

        // Support JSON for AJAX modal
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $jurusan,
            ]);
        }

        return view('jurusan', compact('jurusan'));
    }

    public function kontak()
    {
        // This method is now handled by ContactController
        return app(ContactController::class)->index();
    }
}
