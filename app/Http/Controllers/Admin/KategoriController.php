<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('created_at', 'desc')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori,nama',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.max' => 'Nama kategori maksimal 255 karakter',
            'nama.unique' => 'Nama kategori sudah ada',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status harus Aktif atau Nonaktif',
        ]);

        if ($validator->fails()) {
            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // For regular form submission, redirect back with validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kategori = Kategori::create([
                'nama' => $request->nama,
                'status' => $request->status,
            ]);

            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil dibuat',
                    'data' => $kategori
                ]);
            }

            // For regular form submission, redirect back with success message
            return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dibuat');
        } catch (\Exception $e) {
            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            // For regular form submission, redirect back with error message
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Kategori $kategori)
    {
        // Check if request expects JSON (AJAX request)
        if (request()->expectsJson() || request()->ajax() || request()->header('Accept') === 'application/json' || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true, 'data' => $kategori]);
        }
        
        return view('admin.kategori.show', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $kategori->id,
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.max' => 'Nama kategori maksimal 255 karakter',
            'nama.unique' => 'Nama kategori sudah ada',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status harus Aktif atau Nonaktif',
        ]);

        if ($validator->fails()) {
            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // For regular form submission, redirect back with validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kategori->update([
                'nama' => $request->nama,
                'status' => $request->status,
            ]);

            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil diupdate',
                    'data' => $kategori
                ]);
            }

            // For regular form submission, redirect back with success message
            return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate');
        } catch (\Exception $e) {
            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            // For regular form submission, redirect back with error message
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, Kategori $kategori)
    {
        try {
            // Check if kategori is being used by any foto
            $fotoCount = $kategori->fotos()->count();
            if ($fotoCount > 0) {
                $message = "Kategori tidak dapat dihapus karena masih digunakan oleh {$fotoCount} foto";
                
                // Check if request expects JSON (AJAX request)
                if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                    return response()->json(['success' => false, 'message' => $message], 422);
                }
                
                return redirect()->back()->with('error', $message);
            }

            $kategori->delete();

            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
            }

            // For regular form submission, redirect back with success message
            return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->ajax() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            }

            // For regular form submission, redirect back with error message
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
