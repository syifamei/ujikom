@extends('layouts.admin')

@section('title', 'Pesan Kontak - Admin Panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-envelope me-2"></i>
                    Pesan Kontak
                    @if($unreadCount > 0)
                        <span class="badge bg-danger ms-2">{{ $unreadCount }} Belum Dibaca</span>
                    @endif
                </h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($messages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Subjek</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $index => $message)
                                        <tr class="{{ $message->status === 'unread' ? 'table-warning' : '' }}">
                                            <td>{{ $messages->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $message->nama }}</strong>
                                                @if($message->status === 'unread')
                                                    <i class="fas fa-circle text-danger ms-1" style="font-size: 8px;"></i>
                                                @endif
                                            </td>
                                            <td>{{ $message->email }}</td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $message->subjek }}">
                                                    {{ $message->subjek }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($message->status === 'unread')
                                                    <span class="badge bg-warning">Belum Dibaca</span>
                                                @elseif($message->status === 'read')
                                                    <span class="badge bg-info">Sudah Dibaca</span>
                                                @else
                                                    <span class="badge bg-success">Sudah Dibalas</span>
                                                @endif
                                            </td>
                                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.contact.show', $message->id) }}" 
                                                       class="btn btn-sm btn-primary" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" 
                                                                data-bs-toggle="dropdown" title="Ubah Status">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <form action="{{ route('admin.contact.update-status', $message->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="unread">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-circle text-warning me-2"></i>Belum Dibaca
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('admin.contact.update-status', $message->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="read">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-eye text-info me-2"></i>Sudah Dibaca
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('admin.contact.update-status', $message->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="replied">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-reply text-success me-2"></i>Sudah Dibalas
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" 
                                                          class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pesan kontak</h5>
                            <p class="text-muted">Pesan dari pengunjung akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection













































