{{-- 
    Partial: _form.blade.php
    Digunakan oleh create.blade.php dan edit.blade.php
    Variables yang dibutuhkan: $todo (optional), $kategoriOptions, $prioritasOptions, $tagsOptions, $statusOptions
--}}

<div class="row g-4">
    {{-- Kolom Kiri --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="mb-0 fw-bold" style="font-family:var(--font-display);">
                    <i class="bi bi-pencil-square me-2 text-muted"></i>Informasi Todo
                </h6>
            </div>
            <div class="card-body p-4">

                {{-- 1. TEXTFIELD: Judul --}}
                <div class="mb-4">
                    <label for="judul" class="form-label">
                        Judul Todo <span class="required">*</span>
                        <span class="text-muted fw-normal" style="font-size:0.75rem;">(TextField)</span>
                    </label>
                    <input type="text"
                           id="judul"
                           name="judul"
                           class="form-control @error('judul') is-invalid @enderror"
                           placeholder="Contoh: Menyelesaikan laporan bulanan"
                           value="{{ old('judul', $todo->judul ?? '') }}"
                           maxlength="255">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 2. TEXTFIELD: Deskripsi --}}
                <div class="mb-4">
                    <label for="deskripsi" class="form-label">
                        Deskripsi
                        <span class="text-muted fw-normal" style="font-size:0.75rem;">(TextField multiline)</span>
                    </label>
                    <textarea id="deskripsi"
                              name="deskripsi"
                              class="form-control @error('deskripsi') is-invalid @enderror"
                              rows="3"
                              placeholder="Jelaskan detail tugas ini (opsional)..."
                              maxlength="1000">{{ old('deskripsi', $todo->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="text-end text-muted mt-1" style="font-size:0.75rem;">
                        <span id="deskripsiCount">0</span>/1000 karakter
                    </div>
                </div>

                {{-- 3. DROPDOWN: Kategori --}}
                <div class="mb-4">
                    <label for="kategori" class="form-label">
                        Kategori <span class="required">*</span>
                        <span class="text-muted fw-normal" style="font-size:0.75rem;">(Dropdown)</span>
                    </label>
                    <select id="kategori"
                            name="kategori"
                            class="form-select @error('kategori') is-invalid @enderror">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($kategoriOptions as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('kategori', $todo->kategori ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 4. RADIO BUTTON: Prioritas --}}
                <div class="mb-4">
                    <label class="form-label d-block">
                        Prioritas <span class="required">*</span>
                        <span class="text-muted fw-normal" style="font-size:0.75rem;">(Radio Button)</span>
                    </label>
                    <div class="radio-group @error('prioritas') border border-danger rounded p-2 @enderror">
                        @foreach($prioritasOptions as $val => $label)
                            @php
                                $icons = ['rendah' => '🟢', 'sedang' => '🟡', 'tinggi' => '🔴', 'kritis' => '⚫'];
                            @endphp
                            <div class="radio-option">
                                <input type="radio"
                                       id="prioritas_{{ $val }}"
                                       name="prioritas"
                                       value="{{ $val }}"
                                       {{ old('prioritas', $todo->prioritas ?? '') == $val ? 'checked' : '' }}>
                                <label for="prioritas_{{ $val }}">
                                    {{ $icons[$val] ?? '' }} {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('prioritas')
                        <div class="text-danger mt-1" style="font-size:0.8rem; font-weight:500;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 5. CHECKBOX: Tags --}}
                <div class="mb-4">
                    <label class="form-label d-block">
                        Tags
                        <span class="text-muted fw-normal" style="font-size:0.75rem;">(CheckBox — boleh lebih dari satu)</span>
                    </label>
                    <div class="checkbox-group">
                        @foreach($tagsOptions as $val => $label)
                            @php
                                $selectedTags = old('tags', $todo->tags ?? []);
                            @endphp
                            <div class="checkbox-option">
                                <input type="checkbox"
                                       id="tag_{{ $val }}"
                                       name="tags[]"
                                       value="{{ $val }}"
                                       {{ in_array($val, $selectedTags) ? 'checked' : '' }}>
                                <label for="tag_{{ $val }}">
                                    <i class="bi bi-tag"></i> {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('tags')
                        <div class="text-danger mt-1" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    {{-- Kolom Kanan --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="mb-0 fw-bold" style="font-family:var(--font-display);">
                    <i class="bi bi-sliders me-2 text-muted"></i>Pengaturan
                </h6>
            </div>
            <div class="card-body p-4">

                {{-- 6. DROPDOWN: Status --}}
                <div class="mb-4">
                    <label for="status" class="form-label">
                        Status <span class="required">*</span>
                        <span class="text-muted fw-normal d-block" style="font-size:0.75rem;">(Dropdown)</span>
                    </label>
                    <select id="status"
                            name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="">— Pilih Status —</option>
                        @foreach($statusOptions as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('status', $todo->status ?? 'belum') == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 7. DATE PICKER: Tanggal Deadline --}}
                <div class="mb-4">
                    <label for="tanggal_deadline" class="form-label">
                        Tanggal Deadline <span class="required">*</span>
                        <span class="text-muted fw-normal d-block" style="font-size:0.75rem;">(Date Picker)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-calendar3 text-muted"></i>
                        </span>
                        <input type="text"
                               id="tanggal_deadline"
                               name="tanggal_deadline"
                               class="form-control @error('tanggal_deadline') is-invalid @enderror"
                               placeholder="Pilih tanggal..."
                               value="{{ old('tanggal_deadline', isset($todo) ? $todo->tanggal_deadline->format('Y-m-d') : '') }}"
                               readonly>
                    </div>
                    @error('tanggal_deadline')
                        <div class="text-danger mt-1" style="font-size:0.8rem; font-weight:500;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 8. SWITCH / TOGGLE: Penting --}}
                <div class="mb-2">
                    <label class="form-label d-block">
                        Tandai Penting
                        <span class="text-muted fw-normal d-block" style="font-size:0.75rem;">(Switch / Toggle)</span>
                    </label>
                    <div class="switch-wrapper">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input"
                                   type="checkbox"
                                   role="switch"
                                   id="is_penting"
                                   name="is_penting"
                                   value="1"
                                   {{ old('is_penting', $todo->is_penting ?? false) ? 'checked' : '' }}>
                        </div>
                        <label class="form-check-label mb-0" for="is_penting">
                            <span id="switchLabel" style="font-size:0.88rem; font-weight:500;">
                                {{ old('is_penting', $todo->is_penting ?? false) ? '⭐ Ditandai Penting' : 'Tidak Penting' }}
                            </span>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        {{-- Tombol Submit --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-2"></i>
                @if(isset($todo) && $todo->exists)
                    Simpan Perubahan
                @else
                    Tambah Todo
                @endif
            </button>
            <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Flatpickr Date Picker
    flatpickr("#tanggal_deadline", {
        locale: "id",
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        allowInput: false,
        minDate: "{{ isset($todo) && $todo->exists ? '' : 'today' }}",
        disableMobile: false,
    });

    // Karakter counter deskripsi
    const deskripsiEl = document.getElementById('deskripsi');
    const countEl = document.getElementById('deskripsiCount');
    function updateCount() {
        countEl.textContent = deskripsiEl.value.length;
    }
    deskripsiEl.addEventListener('input', updateCount);
    updateCount();

    // Switch label update
    const switchEl = document.getElementById('is_penting');
    const switchLabel = document.getElementById('switchLabel');
    switchEl.addEventListener('change', function () {
        switchLabel.textContent = this.checked ? '⭐ Ditandai Penting' : 'Tidak Penting';
    });
</script>
@endpush
