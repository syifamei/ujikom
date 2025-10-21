@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">Agenda Sekolah</h3>
    <div class="row g-3">
        @forelse($agendas as $agenda)
        <div class="col-md-4">
            <a href="{{ route('agenda.show', $agenda) }}" class="text-decoration-none text-dark">
                <div class="card h-100">
                    @if($agenda->photo_path)
                        <img src="{{ asset('storage/'.$agenda->photo_path) }}" class="card-img-top" style="height:200px;object-fit:cover;" alt="Agenda">
                    @endif
                    <div class="card-body">
                        <p class="card-text text-muted mb-0">{{ Str::limit(strip_tags($agenda->description), 90) }}</p>
                    </div>
                </div>
            </a>
        </div>
        @empty
            <p class="text-center">Belum ada agenda.</p>
        @endforelse
    </div>
    <div class="mt-3">{{ $agendas->links() }}</div>
</div>
@endsection


