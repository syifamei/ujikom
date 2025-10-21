<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FotoController extends Controller
{
    public function index(): JsonResponse
    {
        $fotos = Foto::with(['galery'])->get();
        return response()->json([
            'success' => true,
            'data' => $fotos
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'galery_id' => 'required|exists:galery,id',
            'file' => 'required|string|max:255',
            'judul' => 'required|string|max:255'
        ]);

        $foto = Foto::create($request->all());
        $foto->load(['galery']);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dibuat',
            'data' => $foto
        ], 201);
    }

    public function show(Foto $foto): JsonResponse
    {
        $foto->load(['galery']);
        return response()->json([
            'success' => true,
            'data' => $foto
        ]);
    }

    public function update(Request $request, Foto $foto): JsonResponse
    {
        $request->validate([
            'galery_id' => 'required|exists:galery,id',
            'file' => 'required|string|max:255',
            'judul' => 'required|string|max:255'
        ]);

        $foto->update($request->all());
        $foto->load(['galery']);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diupdate',
            'data' => $foto
        ]);
    }

    public function destroy(Foto $foto): JsonResponse
    {
        $foto->delete();
        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus'
        ]);
    }
}
