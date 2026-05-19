<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TodoController extends Controller
{
    /**
     * READ - Tampilkan semua todo dalam bentuk list
     */
    public function index(Request $request): View
    {
        $query = Todo::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Search judul
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $todos = $query->orderByRaw("
            CASE prioritas
                WHEN 'kritis' THEN 1
                WHEN 'tinggi' THEN 2
                WHEN 'sedang' THEN 3
                WHEN 'rendah' THEN 4
                ELSE 5
            END
        ")->orderBy('tanggal_deadline')->get();

        $stats = [
            'total'      => Todo::count(),
            'belum'      => Todo::where('status', 'belum')->count(),
            'proses'     => Todo::where('status', 'proses')->count(),
            'selesai'    => Todo::where('status', 'selesai')->count(),
            'terlambat'  => Todo::whereNotIn('status', ['selesai', 'dibatalkan'])
                                ->whereDate('tanggal_deadline', '<', now())
                                ->count(),
        ];

        return view('todos.index', compact('todos', 'stats'));
    }

    /**
     * CREATE - Form tambah todo baru
     */
    public function create(): View
    {
        return view('todos.create', [
            'kategoriOptions' => Todo::$kategoriOptions,
            'prioritasOptions' => Todo::$prioritasOptions,
            'tagsOptions'     => Todo::$tagsOptions,
            'statusOptions'   => Todo::$statusOptions,
        ]);
    }

    /**
     * CREATE - Simpan todo baru ke database
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255|min:3',
            'deskripsi'        => 'nullable|string|max:1000',
            'kategori'         => 'required|in:' . implode(',', array_keys(Todo::$kategoriOptions)),
            'prioritas'        => 'required|in:' . implode(',', array_keys(Todo::$prioritasOptions)),
            'tags'             => 'nullable|array',
            'tags.*'           => 'in:' . implode(',', array_keys(Todo::$tagsOptions)),
            'is_penting'       => 'nullable|boolean',
            'tanggal_deadline' => 'required|date|after_or_equal:today',
            'status'           => 'required|in:' . implode(',', array_keys(Todo::$statusOptions)),
        ], [
            'judul.required'            => 'Judul belum diisi.',
            'judul.min'                 => 'Judul minimal 3 karakter.',
            'kategori.required'         => 'Kategori belum dipilih.',
            'prioritas.required'        => 'Prioritas belum dipilih.',
            'tanggal_deadline.required' => 'Tanggal deadline belum diisi.',
            'tanggal_deadline.after_or_equal' => 'Tanggal deadline tidak boleh sebelum hari ini.',
            'status.required'           => 'Status belum dipilih.',
        ]);

        $validated['is_penting'] = $request->has('is_penting') ? true : false;
        $validated['tags'] = $request->input('tags', []);

        Todo::create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Todo berhasil ditambahkan!');
    }

    /**
     * READ - Detail satu todo
     */
    public function show(Todo $todo): View
    {
        return view('todos.show', compact('todo'));
    }

    /**
     * UPDATE - Form edit todo
     */
    public function edit(Todo $todo): View
    {
        return view('todos.edit', [
            'todo'            => $todo,
            'kategoriOptions' => Todo::$kategoriOptions,
            'prioritasOptions' => Todo::$prioritasOptions,
            'tagsOptions'     => Todo::$tagsOptions,
            'statusOptions'   => Todo::$statusOptions,
        ]);
    }

    /**
     * UPDATE - Simpan perubahan todo
     */
    public function update(Request $request, Todo $todo): RedirectResponse
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255|min:3',
            'deskripsi'        => 'nullable|string|max:1000',
            'kategori'         => 'required|in:' . implode(',', array_keys(Todo::$kategoriOptions)),
            'prioritas'        => 'required|in:' . implode(',', array_keys(Todo::$prioritasOptions)),
            'tags'             => 'nullable|array',
            'tags.*'           => 'in:' . implode(',', array_keys(Todo::$tagsOptions)),
            'is_penting'       => 'nullable|boolean',
            'tanggal_deadline' => 'required|date',
            'status'           => 'required|in:' . implode(',', array_keys(Todo::$statusOptions)),
        ], [
            'judul.required'            => 'Judul belum diisi.',
            'judul.min'                 => 'Judul minimal 3 karakter.',
            'kategori.required'         => 'Kategori belum dipilih.',
            'prioritas.required'        => 'Prioritas belum dipilih.',
            'tanggal_deadline.required' => 'Tanggal deadline belum diisi.',
            'status.required'           => 'Status belum dipilih.',
        ]);

        $validated['is_penting'] = $request->has('is_penting') ? true : false;
        $validated['tags'] = $request->input('tags', []);

        $todo->update($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Todo berhasil diperbarui!');
    }

    /**
     * DELETE - Hapus todo (setelah konfirmasi dari frontend)
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        $judul = $todo->judul;
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', "Todo \"{$judul}\" berhasil dihapus.");
    }

    /**
     * Toggle status selesai cepat
     */
    public function toggleSelesai(Todo $todo): RedirectResponse
    {
        $todo->update([
            'status' => $todo->status === 'selesai' ? 'proses' : 'selesai'
        ]);

        return back()->with('success', 'Status todo diperbarui.');
    }
}
