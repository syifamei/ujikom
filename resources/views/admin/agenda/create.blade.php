@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Tambah Agenda</h3>

    <form action="{{ route('admin.agenda.store') }}" method="POST" enctype="multipart/form-data" class="card p-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Aktif" selected>Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Simpan</button>
            <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection


