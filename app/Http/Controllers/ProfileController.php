<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function index(): JsonResponse
    {
        $profiles = Profile::all();
        return response()->json([
            'success' => true,
            'data' => $profiles
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string'
        ]);

        $profile = Profile::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil dibuat',
            'data' => $profile
        ], 201);
    }

    public function show(Profile $profile): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    public function update(Request $request, Profile $profile): JsonResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string'
        ]);

        $profile->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate',
            'data' => $profile
        ]);
    }

    public function destroy(Profile $profile): JsonResponse
    {
        $profile->delete();
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil dihapus'
        ]);
    }
}
