<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logo.jpg') }}">
    <title>@yield('title', 'TodoList App') — TaskFlow</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Flatpickr CSS (Date picker) -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #1a1a2e;
            --accent: #e94560;
            --accent2: #f5a623;
            --surface: #ffffff;
            --surface2: #f8f7f4;
            --border: #e8e5df;
            --text: #1a1a2e;
            --text-muted: #8b8580;
            --radius: 12px;
            --shadow: 0 4px 24px rgba(26, 26, 46, 0.08);
            --shadow-lg: 0 12px 48px rgba(26, 26, 46, 0.14);
            --font-display: 'Syne', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--surface2);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--primary);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 0;
            z-index: 100;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand h1 {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .sidebar-brand span {
            color: var(--accent);
        }

        .sidebar-brand p {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
            margin: 4px 0 0;
        }

        .sidebar-nav {
            padding: 20px 12px;
            flex: 1;
        }

        .sidebar-nav .nav-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
            padding: 8px 12px 4px;
            margin-top: 12px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 400;
            transition: all .2s;
            margin-bottom: 2px;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(233, 69, 96, 0.15);
            color: #fff;
        }

        .sidebar-nav a.active {
            color: var(--accent);
            font-weight: 600;
        }

        .sidebar-nav a i {
            font-size: 1.1rem;
        }

        /* ── Main content ── */
        .main-wrap {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0;
        }

        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar h2 {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        .page-body {
            padding: 28px 32px;
        }

        /* ── Cards ── */
        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            background: var(--surface);
        }

        /* ── Stats cards ── */
        .stat-card {
            border-radius: var(--radius);
            padding: 36px 32px;
            background: var(--surface);
            border: 1px solid var(--border);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .stat-number {
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 600;
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* ── Todo list items ── */
        .todo-item {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .todo-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .todo-item.prioritas-rendah::before {
            background: #28a745;
        }

        .todo-item.prioritas-sedang::before {
            background: #ffc107;
        }

        .todo-item.prioritas-tinggi::before {
            background: #dc3545;
        }

        .todo-item.prioritas-kritis::before {
            background: #1a1a2e;
        }

        .todo-item:hover {
            box-shadow: var(--shadow-lg);
            transform: translateX(2px);
        }

        .todo-item.status-selesai {
            opacity: 0.6;
            background: #fafafa;
        }

        .todo-item.status-selesai .todo-title {
            text-decoration: line-through;
            color: var(--text-muted);
        }

        .todo-item.overdue {
            border-color: #dc354540;
            background: #fff5f5;
        }

        .todo-check {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid var(--border);
            cursor: pointer;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            margin-top: 1px;
        }

        .todo-check:hover {
            border-color: var(--accent);
        }

        .todo-check.checked {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .todo-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .todo-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .todo-actions {
            margin-left: auto;
            display: flex;
            gap: 4px;
            flex-shrink: 0;
        }

        /* ── Badges ── */
        .badge-kategori {
            background: rgba(26, 26, 46, 0.08);
            color: var(--text);
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        /* ── Forms ── */
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text);
            margin-bottom: 6px;
        }

        .form-label .required {
            color: var(--accent);
            margin-left: 2px;
        }

        .form-control,
        .form-select {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: var(--font-body);
            font-size: 0.9rem;
            padding: 10px 14px;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: var(--accent);
        }

        .invalid-feedback {
            color: var(--accent);
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Custom Radio Buttons */
        .radio-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .radio-option {
            position: relative;
        }

        .radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .radio-option label {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all .2s;
            user-select: none;
        }

        .radio-option input:checked+label {
            border-color: var(--accent);
            background: rgba(233, 69, 96, 0.06);
            color: var(--accent);
        }

        .radio-option label:hover {
            border-color: var(--accent);
        }

        /* Custom Checkboxes */
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .checkbox-option {
            position: relative;
        }

        .checkbox-option input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .checkbox-option label {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.83rem;
            font-weight: 500;
            transition: all .2s;
            user-select: none;
        }

        .checkbox-option input:checked+label {
            border-color: #0d6efd;
            background: rgba(13, 110, 253, 0.06);
            color: #0d6efd;
        }

        /* Switch/Toggle */
        .switch-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
        }

        .form-switch .form-check-input {
            width: 44px;
            height: 24px;
            cursor: pointer;
        }

        .form-switch .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        /* ── Buttons ── */
        .btn-primary {
            background: var(--accent);
            border-color: var(--accent);
            font-family: var(--font-body);
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 24px;
        }

        .btn-primary:hover {
            background: #c73854;
            border-color: #c73854;
        }

        .btn-outline-secondary {
            border-radius: 8px;
            font-weight: 500;
        }

        /* ── Alerts ── */
        .alert {
            border-radius: var(--radius);
            border: none;
            font-size: 0.9rem;
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state .empty-icon {
            font-size: 3.5rem;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrap {
                margin-left: 0;
            }

            .page-body {
                padding: 16px;
            }

            .topbar {
                padding: 14px 16px;
            }
        }

        /* Flatpickr custom */
        .flatpickr-calendar {
            border-radius: var(--radius) !important;
            box-shadow: var(--shadow-lg) !important;
        }

        .flatpickr-day.selected {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .todo-item {
            animation: slideIn .2s ease both;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h1><span>Task</span>Flow</h1>
            <p>Manajemen Tugas Harian</p>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Menu</div>
            <a href="{{ route('todos.index') }}" class="{{ request()->routeIs('todos.index') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i> Semua Todo
            </a>
            <a href="{{ route('todos.create') }}" class="{{ request()->routeIs('todos.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Tambah Todo
            </a>

            <div class="nav-label" style="margin-top:20px">Filter Cepat</div>
            <a href="{{ route('todos.index', ['status' => 'belum']) }}">
                <i class="bi bi-circle"></i> Belum Dikerjakan
            </a>
            <a href="{{ route('todos.index', ['status' => 'proses']) }}">
                <i class="bi bi-arrow-clockwise"></i> Sedang Dikerjakan
            </a>
            <a href="{{ route('todos.index', ['status' => 'selesai']) }}">
                <i class="bi bi-check-circle"></i> Selesai
            </a>
            <a href="{{ route('todos.index', ['prioritas' => 'kritis']) }}">
                <i class="bi bi-exclamation-circle"></i> Prioritas Kritis
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <div class="main-wrap">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h2>@yield('page-title', 'Dashboard')</h2>
            </div>
            <a href="{{ route('todos.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-1"></i> Tambah Todo
            </a>
        </div>

        <!-- Page Body -->
        <div class="page-body">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden;">
                <div class="modal-body text-center p-5">
                    <div style="font-size:3rem; margin-bottom:16px;">🗑️</div>
                    <h5 style="font-family:var(--font-display); font-weight:700; margin-bottom:8px;">Hapus Todo?</h5>
                    <p class="text-muted mb-4" id="deleteModalText">Apakah Anda yakin ingin menghapus todo ini? Tindakan
                        ini tidak dapat dibatalkan.</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <form id="deleteForm" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-trash me-1"></i> Ya, Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        // Sidebar toggle (mobile)
        document.getElementById('sidebarToggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
        });

        // Delete confirmation modal
        function confirmDelete(id, judul, url) {
            document.getElementById('deleteModalText').textContent =
                `Apakah Anda yakin ingin menghapus todo "${judul}"? Tindakan ini tidak dapat dibatalkan.`;
            document.getElementById('deleteForm').action = url;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>

    @stack('scripts')
</body>

</html>