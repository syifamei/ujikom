@extends('layouts.app')

@section('content')
<div class="container py-4">
    <a href="{{ route('agenda.index') }}" class="btn btn-link">&larr; Kembali</a>
    <div class="card">
        @if($agenda->photo_path)
            <img src="{{ asset('storage/'.$agenda->photo_path) }}" class="card-img-top" style="max-height:360px;object-fit:cover;" alt="Agenda">
        @endif
        <div class="card-body">
            <div class="card-text">{!! nl2br(e($agenda->description)) !!}</div>
        </div>
    </div>
</div>
@endsection


