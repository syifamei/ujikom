@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak - Admin Panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-envelope-open me-2"></i>
                    Detail Pesan Kontak
                </h1>
                <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Pesan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Nama:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $message->nama }}
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                        {{ $message->email }}
                                        <i class="fas fa-external-link-alt ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Subjek:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $message->subjek }}
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Status:</strong>
                                </div>
                                <div class="col-sm-9">
                                    @if($message->status === 'unread')
                                        <span class="badge bg-warning">Belum Dibaca</span>
                                    @elseif($message->status === 'read')
                                        <span class="badge bg-info">Sudah Dibaca</span>
                                    @else
                                        <span class="badge bg-success">Sudah Dibalas</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Tanggal Kirim:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $message->created_at->format('d F Y, H:i') }}
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-3">
                                    <strong>Pesan:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <div class="border rounded p-3 bg-light">
                                        {{ $message->pesan }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-cogs me-2"></i>
                                Aksi
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <!-- Update Status -->
                                <div class="mb-3">
                                    <label class="form-label"><strong>Ubah Status:</strong></label>
                                    <div class="d-grid gap-2">
                                        <form action="{{ route('admin.contact.update-status', $message->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="unread">
                                            <button type="submit" class="btn btn-warning w-100">
                                                <i class="fas fa-circle me-2"></i>Belum Dibaca
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.contact.update-status', $message->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="read">
                                            <button type="submit" class="btn btn-info w-100">
                                                <i class="fas fa-eye me-2"></i>Sudah Dibaca
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.contact.update-status', $message->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="replied">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-reply me-2"></i>Sudah Dibalas
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="mb-3">
                                    <label class="form-label"><strong>Aksi Cepat:</strong></label>
                                    <div class="d-grid gap-2">
                                        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subjek }}" 
                                           class="btn btn-primary">
                                            <i class="fas fa-reply me-2"></i>Balas Email
                                        </a>
                                        
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="copyToClipboard('{{ $message->email }}')">
                                            <i class="fas fa-copy me-2"></i>Salin Email
                                        </button>
                                    </div>
                                </div>

                                <!-- Delete -->
                                <div class="border-top pt-3">
                                    <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-trash me-2"></i>Hapus Pesan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Info -->
                    <div class="card mt-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info me-2"></i>
                                Informasi Tambahan
                            </h6>
                        </div>
                        <div class="card-body">
                            <small class="text-muted">
                                <strong>ID Pesan:</strong> #{{ $message->id }}<br>
                                <strong>Terakhir Diupdate:</strong> {{ $message->updated_at->format('d/m/Y H:i') }}<br>
                                <strong>Durasi:</strong> {{ $message->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-2"></i>Tersalin!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>
@endsection













































