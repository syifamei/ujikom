<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    // ADMIN CRUD
    public function index()
    {
        $agendas = Agenda::latest()->paginate(12);
        return view('admin.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('agenda', 'public');
        }

        $requestedStatus = $request->input('status', 'Aktif');

        $data = [
            'description' => $request->description,
            'photo_path' => $photoPath,
            'status' => $requestedStatus,
        ];
        if (Schema::hasColumn('agendas', 'title')) {
            $generatedTitle = trim(Str::limit(strip_tags($request->description), 60, '')) ?: 'Agenda';
            $data['title'] = $generatedTitle;
        }
        if (Schema::hasColumn('agendas', 'judul')) {
            $generatedTitle = trim(Str::limit(strip_tags($request->description), 60, '')) ?: 'Agenda';
            $data['judul'] = $generatedTitle;
        }
        if (Schema::hasColumn('agendas', 'scheduled_at')) {
            $data['scheduled_at'] = now();
        }
        if (Schema::hasColumn('agendas', 'deskripsi')) {
            $data['deskripsi'] = $request->description;
        }

        Agenda::create($data);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda ditambahkan');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $data = $request->only('description','status');
        // keep status as provided ('Aktif' or 'Nonaktif')
        if (Schema::hasColumn('agendas', 'title')) {
            $generatedTitle = trim(Str::limit(strip_tags($request->description), 60, '')) ?: 'Agenda';
            $data['title'] = $generatedTitle;
        }
        if (Schema::hasColumn('agendas', 'judul')) {
            $generatedTitle = trim(Str::limit(strip_tags($request->description), 60, '')) ?: 'Agenda';
            $data['judul'] = $generatedTitle;
        }
        if (Schema::hasColumn('agendas', 'deskripsi')) {
            $data['deskripsi'] = $request->description;
        }
        if ($request->hasFile('photo')) {
            if ($agenda->photo_path) {
                Storage::disk('public')->delete($agenda->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('agenda', 'public');
        }

        $agenda->update($data);
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda diperbarui');
    }

    public function destroy(Agenda $agenda)
    {
        if ($agenda->photo_path) {
            Storage::disk('public')->delete($agenda->photo_path);
        }
        $agenda->delete();
        return back()->with('success', 'Agenda dihapus');
    }

    // PUBLIC
    public function publicIndex()
    {
        $agendas = Agenda::where('status','Aktif')->latest()->paginate(12);
        return view('agenda.index', compact('agendas'));
    }

    public function publicShow(Agenda $agenda)
    {
        abort_unless($agenda->status === 'Aktif', 404);
        return view('agenda.show', compact('agenda'));
    }
}


