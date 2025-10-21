<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:petugas',
            'password' => 'required|string|min:6|confirmed'
        ]);

        Petugas::create([
            'username' => $request->username,
            'password' => $request->password // Simpan sebagai plain text untuk ditampilkan
        ]);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function show(Petugas $petuga)
    {
        return view('admin.petugas.show', compact('petuga'));
    }

    public function edit(Petugas $petuga)
    {
        return view('admin.petugas.edit', compact('petuga'));
    }

    public function update(Request $request, Petugas $petuga)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:petugas,username,' . $petuga->id,
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        $data = ['username' => $request->username];
        if ($request->filled('password')) {
            $data['password'] = $request->password; // Simpan sebagai plain text untuk ditampilkan
        }

        $petuga->update($data);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil diupdate!');
    }

    public function destroy(Petugas $petuga)
    {
        $petuga->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil dihapus!');
    }
}