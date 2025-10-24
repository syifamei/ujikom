<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::orderBy('scheduled_at', 'desc')
            ->paginate(10);

        return view('admin.agenda.index', compact('agendas'));
    }

    public function publicIndex()
    {
        $agendas = Agenda::where('status', 'Aktif')
            ->orderBy('scheduled_at', 'desc')
            ->paginate(12);

        return view('agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif'
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

        // Combine tanggal and waktu into scheduled_at
        $scheduledAt = $request->tanggal;
        if ($request->waktu) {
            $scheduledAt .= ' ' . $request->waktu;
        }

            $data = [
                'title' => $request->judul,
                'description' => $request->deskripsi,
                'scheduled_at' => $scheduledAt,
                'status' => $request->status
            ];

        Agenda::create($data);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function show($id)
    {
        try {
            $agenda = Agenda::findOrFail($id);
            
            // Check if request expects JSON response (AJAX)
            if (request()->expectsJson() || request()->ajax() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'data' => $agenda
                ]);
            }
            
            return view('admin.agenda.show', compact('agenda'));
        } catch (\Exception $e) {
            // Check if request expects JSON response (AJAX)
            if (request()->expectsJson() || request()->ajax() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Agenda tidak ditemukan!'
                ], 404);
            }
            
            return redirect()->route('admin.agenda.index')
                ->with('error', 'Agenda tidak ditemukan!');
        }
    }

    public function publicShow(Agenda $agenda)
    {
        return view('agenda.show', compact('agenda'));
    }

    public function edit($id)
    {
        try {
            $agenda = Agenda::findOrFail($id);
            return view('admin.agenda.edit', compact('agenda'));
        } catch (\Exception $e) {
            return redirect()->route('admin.agenda.index')
                ->with('error', 'Agenda tidak ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $agenda = Agenda::findOrFail($id);
            
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:1000',
                'tanggal' => 'required|date',
                'waktu' => 'nullable|string|max:50',
                'lokasi' => 'nullable|string|max:255',
                'status' => 'required|in:Aktif,Nonaktif'
            ]);

            // Combine tanggal and waktu into scheduled_at
            $scheduledAt = $request->tanggal;
            if ($request->waktu) {
                $scheduledAt .= ' ' . $request->waktu;
            }

            $data = [
                'title' => $request->judul,
                'description' => $request->deskripsi,
                'scheduled_at' => $scheduledAt,
                'status' => $request->status
            ];

            $agenda->update($data);

            // Check if request expects JSON response (AJAX)
            if ($request->expectsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Agenda berhasil diperbarui!',
                    'data' => $agenda->fresh()
                ]);
            }

            return redirect()->route('admin.agenda.index')
                ->with('success', 'Agenda berhasil diperbarui!');
        } catch (\Exception $e) {
            // Check if request expects JSON response (AJAX)
            if ($request->expectsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui agenda: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.agenda.index')
                ->with('error', 'Gagal memperbarui agenda!');
        }
    }

    public function destroy($id)
    {
        try {
            $agenda = Agenda::findOrFail($id);
            $agenda->delete();

            return redirect()->route('admin.agenda.index')
                ->with('success', 'Agenda berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.agenda.index')
                ->with('error', 'Gagal menghapus agenda!');
        }
    }
}