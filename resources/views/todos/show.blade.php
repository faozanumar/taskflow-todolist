@extends('layouts.app')

@section('title', $todo->judul)
@section('page-title', 'Detail Todo')

@section('content')

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('todos.index') }}">Semua Todo</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($todo->judul, 40) }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">

                {{-- Header --}}
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                            <span class="badge bg-{{ $todo->prioritas_color }} fs-6">
                                {{ ucfirst($todo->prioritas) }}
                            </span>
                            <span class="badge bg-{{ $todo->status_color }}">
                                {{ \App\Models\Todo::$statusOptions[$todo->status] ?? $todo->status }}
                            </span>
                            @if($todo->is_penting)
                                <span class="badge" style="background:#fff3cd; color:#856404;">
                                    ⭐ Penting
                                </span>
                            @endif
                            @if($todo->isOverdue())
                                <span class="badge bg-danger">
                                    ⏰ Terlambat
                                </span>
                            @endif
                        </div>
                        <h3 style="font-family:var(--font-display); font-weight:700;">
                            {{ $todo->judul }}
                        </h3>
                    </div>
                </div>

                {{-- Deskripsi --}}
                @if($todo->deskripsi)
                    <div class="mb-4">
                        <h6 class="text-muted fw-semibold mb-2" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px;">Deskripsi</h6>
                        <p style="line-height:1.7; color:#444;">{{ $todo->deskripsi }}</p>
                    </div>
                    <hr>
                @endif

                {{-- Detail grid --}}
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div style="background:#f8f7f4; border-radius:8px; padding:14px;">
                            <div class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Kategori</div>
                            <div class="fw-semibold">
                                🗂️ {{ \App\Models\Todo::$kategoriOptions[$todo->kategori] ?? $todo->kategori }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="background:#f8f7f4; border-radius:8px; padding:14px;">
                            <div class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tanggal Deadline</div>
                            <div class="fw-semibold {{ $todo->isOverdue() ? 'text-danger' : '' }}">
                                📅 {{ $todo->tanggal_deadline->format('d F Y') }}
                                <small class="text-muted d-block fw-normal">
                                    {{ $todo->tanggal_deadline->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="background:#f8f7f4; border-radius:8px; padding:14px;">
                            <div class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Prioritas</div>
                            <div class="fw-semibold">
                                <span class="badge bg-{{ $todo->prioritas_color }}">
                                    {{ ucfirst($todo->prioritas) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="background:#f8f7f4; border-radius:8px; padding:14px;">
                            <div class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Ditandai Penting</div>
                            <div class="fw-semibold">
                                @if($todo->is_penting)
                                    <span style="color:#f5a623;">⭐Ya, Penting</span>
                                @else
                                    <span class="text-muted">Tidak</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($todo->tags && count($todo->tags) > 0)
                    <div class="col-12">
                        <div style="background:#f8f7f4; border-radius:8px; padding:14px;">
                            <div class="text-muted mb-2" style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tags</div>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($todo->tags as $tag)
                                    <span style="background:#e8e5df; padding:4px 12px; border-radius:20px; font-size:0.82rem; font-weight:500;">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Timestamps --}}
                <div class="mt-4 pt-3 border-top text-muted" style="font-size:0.78rem;">
                    <i class="bi bi-clock me-1"></i>
                    Dibuat {{ $todo->created_at->format('d M Y, H:i') }} &nbsp;·&nbsp;
                    Diperbarui {{ $todo->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Actions --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white py-3 px-4">
                <h6 class="mb-0 fw-bold" style="font-family:var(--font-display);">Aksi</h6>
            </div>
            <div class="card-body p-4 d-grid gap-2">

                {{-- Toggle selesai --}}
                <form action="{{ route('todos.toggle-selesai', $todo) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn w-100 {{ $todo->status === 'selesai' ? 'btn-outline-secondary' : 'btn-success' }}">
                        <i class="bi bi-{{ $todo->status === 'selesai' ? 'arrow-counterclockwise' : 'check2-circle' }} me-2"></i>
                        {{ $todo->status === 'selesai' ? 'Tandai Belum Selesai' : 'Tandai Selesai' }}
                    </button>
                </form>

                <a href="{{ route('todos.edit', $todo) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i> Edit Todo
                </a>

                <button type="button" class="btn btn-outline-danger"
                    onclick="confirmDelete({{ $todo->id }}, '{{ addslashes($todo->judul) }}', '{{ route('todos.destroy', $todo) }}')">
                    <i class="bi bi-trash me-2"></i> Hapus Todo
                </button>

                <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke List
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
