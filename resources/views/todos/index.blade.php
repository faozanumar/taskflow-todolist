@extends('layouts.app')

@section('title', 'Semua Todo')
@section('page-title', 'Semua Todo')

@section('content')

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-number text-primary">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Todo</div>
                </div>
                <div class="stat-icon" style="background:rgba(13,110,253,0.1); color:#0d6efd;">
                    <i class="bi bi-list-task"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-number" style="color:#e94560;">{{ $stats['belum'] }}</div>
                    <div class="stat-label">Belum Mulai</div>
                </div>
                <div class="stat-icon" style="background:rgba(233,69,96,0.1); color:#e94560;">
                    <i class="bi bi-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-number" style="color:#28a745;">{{ $stats['selesai'] }}</div>
                    <div class="stat-label">Selesai</div>
                </div>
                <div class="stat-icon" style="background:rgba(40,167,69,0.1); color:#28a745;">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-number" style="color:#dc3545;">{{ $stats['terlambat'] }}</div>
                    <div class="stat-label">Terlambat</div>
                </div>
                <div class="stat-icon" style="background:rgba(220,53,69,0.1); color:#dc3545;">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="card mb-4">
    <div class="card-body p-3">
        <form action="{{ route('todos.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                        placeholder="Cari judul todo..."
                        value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Todo::$statusOptions as $val => $label)
                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Todo::$kategoriOptions as $val => $label)
                        <option value="{{ $val }}" {{ request('kategori') == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="prioritas" class="form-select form-select-sm">
                    <option value="">Semua Prioritas</option>
                    @foreach(\App\Models\Todo::$prioritasOptions as $val => $label)
                        <option value="{{ $val }}" {{ request('prioritas') == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center" title="Reset Filter">
                    <i class="bi bi-x fs-4"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Todo List --}}
@if($todos->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">📋</div>
        <h5 style="font-family:var(--font-display); font-weight:700;">Belum ada todo</h5>
        <p class="text-muted">Yuk, mulai tambahkan tugas pertama Anda!</p>
        <a href="{{ route('todos.create') }}" class="btn btn-primary mt-2">
            <i class="bi bi-plus me-1"></i> Tambah Todo Pertama
        </a>
    </div>
@else
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="text-muted mb-0 small">
            Menampilkan <strong>{{ $todos->count() }}</strong> todo
        </p>
    </div>

    @foreach($todos as $i => $todo)
        <div class="todo-item prioritas-{{ $todo->prioritas }} status-{{ $todo->status }} {{ $todo->isOverdue() ? 'overdue' : '' }}"
             style="animation-delay: {{ $i * 0.03 }}s">

            {{-- Toggle Selesai --}}
            <form action="{{ route('todos.toggle-selesai', $todo) }}" method="POST" style="display:contents;">
                @csrf @method('PATCH')
                <button type="submit" class="todo-check {{ $todo->status === 'selesai' ? 'checked' : '' }}"
                        title="{{ $todo->status === 'selesai' ? 'Tandai Belum Selesai' : 'Tandai Selesai' }}">
                    @if($todo->status === 'selesai')
                        <i class="bi bi-check" style="font-size:0.8rem;"></i>
                    @endif
                </button>
            </form>

            {{-- Content --}}
            <div class="flex-grow-1 min-width-0">
                <div class="d-flex align-items-start gap-2 flex-wrap">
                    <div class="todo-title">
                        @if($todo->is_penting)
                            <i class="bi bi-star-fill text-warning me-1" style="font-size:0.85rem;"></i>
                        @endif
                        {{ $todo->judul }}
                    </div>
                    <span class="badge bg-{{ $todo->prioritas_color }} ms-0" style="font-size:0.7rem; font-weight:600;">
                        {{ ucfirst($todo->prioritas) }}
                    </span>
                </div>

                @if($todo->deskripsi)
                    <p class="text-muted mb-1" style="font-size:0.83rem; margin-top:2px;">
                        {{ Str::limit($todo->deskripsi, 80) }}
                    </p>
                @endif

                <div class="todo-meta">
                    <span class="badge-kategori">
                        {{ \App\Models\Todo::$kategoriOptions[$todo->kategori] ?? $todo->kategori }}
                    </span>

                    <span class="badge bg-{{ $todo->status_color }}" style="font-size:0.7rem;">
                        {{ \App\Models\Todo::$statusOptions[$todo->status] ?? $todo->status }}
                    </span>

                    <span class="{{ $todo->isOverdue() ? 'text-danger fw-semibold' : '' }}">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $todo->tanggal_deadline->format('d M Y') }}
                        @if($todo->isOverdue())
                            <span class="badge bg-danger ms-1" style="font-size:0.65rem;">Terlambat</span>
                        @endif
                    </span>

                    @if($todo->tags && count($todo->tags) > 0)
                        @foreach($todo->tags as $tag)
                            <span style="background:#f0f0f0; padding:2px 8px; border-radius:20px; font-size:0.7rem;">
                                #{{ $tag }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="todo-actions">
                <a href="{{ route('todos.show', $todo) }}" class="btn btn-sm btn-outline-secondary" title="Detail">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('todos.edit', $todo) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                    onclick="confirmDelete({{ $todo->id }}, '{{ addslashes($todo->judul) }}', '{{ route('todos.destroy', $todo) }}')">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    @endforeach
@endif

@endsection
