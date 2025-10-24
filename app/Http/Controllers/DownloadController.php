<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;
use App\Models\DownloadLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function registerAndDownload(Request $request, Foto $foto)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Harap isi semua data dengan benar sebelum mengunduh foto',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Log download activity
            DownloadLog::create([
                'foto_id' => $foto->id,
                'nama' => $request->nama,
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'success',
                'tujuan' => 'gallery_download'
            ]);

            // Get file path
            $filePath = storage_path('app/public/' . $foto->path);
            
            // Check if file exists
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan'
                ], 404);
            }

            // Return download response
            return response()->download($filePath, $foto->judul . '.jpg');

        } catch (\Exception $e) {
            // Log failed download
            DownloadLog::create([
                'foto_id' => $foto->id,
                'nama' => $request->nama ?? 'Unknown',
                'email' => $request->email ?? 'Unknown',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'failed',
                'tujuan' => 'gallery_download'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadSuccess()
    {
        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diunduh! Terima kasih telah menggunakan galeri kami'
        ]);
    }
}
