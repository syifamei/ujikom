<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GaleryController extends Controller
{
    public function index(): JsonResponse
    {
        $galeries = Galery::with(['post'])->get();
        return response()->json([
            'success' => true,
            'data' => $galeries
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'position' => 'required|integer',
            'status' => 'required|integer|in:0,1'
        ]);

        $galery = Galery::create($request->all());
        $galery->load(['post']);

        return response()->json([
            'success' => true,
            'message' => 'Galery berhasil dibuat',
            'data' => $galery
        ], 201);
    }

    public function show(Galery $galery): JsonResponse
    {
        $galery->load(['post']);
        return response()->json([
            'success' => true,
            'data' => $galery
        ]);
    }

    public function update(Request $request, Galery $galery): JsonResponse
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'position' => 'required|integer',
            'status' => 'required|integer|in:0,1'
        ]);

        $galery->update($request->all());
        $galery->load(['post']);

        return response()->json([
            'success' => true,
            'message' => 'Galery berhasil diupdate',
            'data' => $galery
        ]);
    }

    public function destroy(Galery $galery): JsonResponse
    {
        $galery->delete();
        return response()->json([
            'success' => true,
            'message' => 'Galery berhasil dihapus'
        ]);
    }
}
