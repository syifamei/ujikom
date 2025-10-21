<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
    public function index()
    {
        $informasis = Informasi::with('admin')
            ->orderBy('tanggal_posting', 'desc')
            ->paginate(10);

        return view('admin.informasi.index', compact('informasis'));
    }

    public function publicIndex()
    {
        $informasis = Informasi::orderBy('tanggal_posting', 'desc')
            ->paginate(12);

        return view('informasi.index', compact('informasis'));
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:500'
        ]);

        // Cari user admin atau buat default
        $admin = \App\Models\User::first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name' => 'Admin',
                'email' => 'admin@smkn4bogor.sch.id',
                'password' => bcrypt('password'),
            ]);
        }

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->deskripsi, // Gunakan deskripsi sebagai konten
            'status' => 'Aktif', // Default aktif
            'tanggal_posting' => date('Y-m-d'), // Default hari ini
            'admin_id' => $admin->id
        ];

        Informasi::create($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function show($id)
    {
        try {
            $informasi = Informasi::findOrFail($id);
            return view('admin.informasi.show', compact('informasi'));
        } catch (\Exception $e) {
            return redirect()->route('admin.informasi.index')
                ->with('error', 'Informasi tidak ditemukan!');
        }
    }

    public function publicShow(Informasi $informasi)
    {
        return view('informasi.show', compact('informasi'));
    }

    public function edit($id)
    {
        try {
            $informasi = Informasi::findOrFail($id);
            return view('admin.informasi.edit', compact('informasi'));
        } catch (\Exception $e) {
            return redirect()->route('admin.informasi.index')
                ->with('error', 'Informasi tidak ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $informasi = Informasi::findOrFail($id);
            
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:500',
                'konten' => 'required|string'
            ]);

            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'konten' => $request->konten
            ];

            $informasi->update($data);

            return redirect()->route('admin.informasi.index')
                ->with('success', 'Informasi berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.informasi.index')
                ->with('error', 'Gagal memperbarui informasi!');
        }
    }

    public function destroy($id)
    {
        try {
            $informasi = Informasi::findOrFail($id);
            $informasi->delete();

            return redirect()->route('admin.informasi.index')
                ->with('success', 'Informasi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.informasi.index')
                ->with('error', 'Gagal menghapus informasi!');
        }
    }
}
