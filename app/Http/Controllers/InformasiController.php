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
        \DB::beginTransaction();
        
        try {
            // Validate the request
            $validator = \Validator::make($request->all(), [
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:500',
                'konten' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'judul.required' => 'Judul informasi harus diisi',
                'judul.max' => 'Judul maksimal 255 karakter',
                'deskripsi.required' => 'Deskripsi singkat harus diisi',
                'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
                'konten.required' => 'Konten informasi harus diisi',
                'gambar.image' => 'File harus berupa gambar',
                'gambar.mimes' => 'Format gambar yang didukung: jpeg, png, jpg, gif',
                'gambar.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the informasi
            $informasi = Informasi::findOrFail($id);
            
            // Prepare data for update
            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'konten' => $request->konten,
                'admin_id' => auth()->id() ?? 1
            ];

            // Handle file upload if new image is provided
            if ($request->hasFile('gambar')) {
                try {
                    // Set the upload path
                    $uploadPath = storage_path('app/public/informasi');
                    
                    // Create directory if it doesn't exist
                    if (!file_exists($uploadPath)) {
                        \File::makeDirectory($uploadPath, 0755, true);
                    }
                    
                    // Delete old image if exists
                    if ($informasi->gambar) {
                        $oldImagePath = storage_path('app/public/informasi/' . $informasi->gambar);
                        if (file_exists($oldImagePath)) {
                            \File::delete($oldImagePath);
                        }
                    }
                    
                    // Generate unique filename
                    $image = $request->file('gambar');
                    $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.]/', '_', $image->getClientOriginalName());
                    
                    // Store the file using Laravel's storage
                    $path = $request->file('gambar')->storeAs('public/informasi', $imageName);
                    
                    // Add the image name to data array (without 'public/' prefix)
                    $data['gambar'] = $imageName;
                } catch (\Exception $e) {
                    \Log::error('Error uploading image: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal mengunggah gambar: ' . $e->getMessage()
                    ], 500);
                }
            }

            // Update the record
            $informasi->update($data);
            
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Informasi berhasil diperbarui!',
                'redirect' => route('admin.informasi.index')
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error updating informasi: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
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
