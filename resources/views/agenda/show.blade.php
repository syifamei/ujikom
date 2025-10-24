@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('agenda.index') }}" class="text-decoration-none d-inline-flex align-items-center mb-3">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
    <div class="agenda-detail">
        <h2 class="agenda-detail-title">{{ $agenda->title ?? $agenda->judul ?? 'Agenda' }}</h2>
        <div class="agenda-detail-body">
            <div class="agenda-detail-content">{!! nl2br(e($agenda->description ?? $agenda->deskripsi ?? '')) !!}</div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .agenda-detail { background:#fff; border:1px solid #e9ecef; border-radius:16px; box-shadow:0 10px 30px rgba(16,24,40,.08); overflow:hidden; }
    .agenda-detail-title { margin:0; padding:1.25rem 1.25rem .25rem; font-weight:700; color:#0f172a; }
    .agenda-detail-body { padding: .25rem 1.25rem 1.25rem; }
    .agenda-detail-content { color:#334155; line-height:1.7; }
    @media (max-width:576px){ .agenda-detail-title{ font-size:1.25rem; } }
</style>
@endsection


