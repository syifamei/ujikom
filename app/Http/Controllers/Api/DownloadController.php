<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DownloadLog;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DownloadController extends Controller
{
    /**
     * Request to download a photo
     */
    public function requestDownload(Request $request, Foto $foto)
    {
        $validator = Validator::make($request->all(), [
            'purpose' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Log the download request
        $downloadLog = DownloadLog::create([
            'user_id' => $request->user()->id,
            'foto_id' => $foto->id,
            'purpose' => $request->purpose,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Generate a temporary download URL (valid for 30 minutes)
        $downloadUrl = Storage::temporaryUrl(
            $foto->path,
            now()->addMinutes(30),
            [
                'response-content-disposition' => 'attachment; filename="' . basename($foto->path) . '"',
            ]
        );

        return response()->json([
            'message' => 'Permintaan unduhan berhasil',
            'download_url' => $downloadUrl,
            'expires_at' => now()->addMinutes(30)->toDateTimeString(),
        ]);
    }
}
