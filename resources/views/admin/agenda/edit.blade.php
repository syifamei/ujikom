@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Edit Agenda</h3>

    <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST" enctype="multipart/form-data" class="card p-3">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description', $agenda->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto</label>
            @if($agenda->photo_path)
                <div class="mb-2"><img src="{{ asset('storage/'.$agenda->photo_path) }}" style="height:100px;object-fit:cover;"></div>
            @endif
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Aktif" {{ $agenda->status==='Aktif'?'selected':'' }}>Aktif</option>
                <option value="Nonaktif" {{ $agenda->status==='Nonaktif'?'selected':'' }}>Nonaktif</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection


