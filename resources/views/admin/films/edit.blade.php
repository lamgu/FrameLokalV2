@extends('layouts.admin')

@section('title', 'Edit Film')
@section('page-title', 'Edit Film')

@section('content')

{{-- BREADCRUMB --}}
<div class="flex items-center gap-2 text-[13px] text-gray-500 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#f5c518] transition-colors">Dashboard</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <a href="{{ route('admin.films.index') }}" class="hover:text-[#f5c518] transition-colors">Film</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <span class="text-gray-300">Edit: {{ $film->title }}</span>
</div>

<form method="POST" action="{{ route('admin.films.update', $film) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="grid grid-cols-[1fr_340px] gap-5">

        {{-- LEFT COLUMN --}}
        <div class="flex flex-col gap-4">

            {{-- Judul --}}
            <div class="bg-surface border border-white/[0.07] rounded-xl p-5">
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Judul Film <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title', $film->title) }}"
                       class="w-full bg-surface-2 border @error('title') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[14px] text-gray-100 placeholder-gray-500 outline-none focus:border-[#c9a014] transition-colors font-sans">
                @error('title')
                    <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                @enderror
                <p class="mt-1.5 text-[11px] text-gray-600">Slug: <span class="font-mono text-gray-500">{{ $film->slug }}</span></p>
            </div>

            {{-- Synopsis --}}
            <div class="bg-surface border border-white/[0.07] rounded-xl p-5">
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Sinopsis <span class="text-red-400">*</span></label>
                <textarea name="synopsis" rows="6"
                          class="w-full bg-surface-2 border @error('synopsis') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[14px] text-gray-100 outline-none focus:border-[#c9a014] transition-colors font-sans resize-none">{{ old('synopsis', $film->synopsis) }}</textarea>
                @error('synopsis')
                    <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Lokasi --}}
            <div class="bg-surface border border-white/[0.07] rounded-xl p-5">
                <p class="text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-4">Lokasi Asal <span class="text-red-400">*</span></p>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[12px] text-gray-400 mb-1.5">Provinsi</label>
                        <select name="province_id" id="province-select"
                                class="w-full bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-2.5 text-[13px] text-gray-300 outline-none focus:border-[#c9a014] transition-colors font-sans cursor-pointer">
                            <option value="">— Pilih Provinsi —</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ (old('province_id', $film->regency->province_id ?? '') == $province->id) ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[12px] text-gray-400 mb-1.5">Kabupaten / Kota <span class="text-red-400">*</span></label>
                        <select name="regency_id" id="regency-select"
                                class="w-full bg-surface-2 border @error('regency_id') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-3 py-2.5 text-[13px] text-gray-300 outline-none focus:border-[#c9a014] transition-colors font-sans cursor-pointer">
                            <option value="">Memuat...</option>
                        </select>
                        @error('regency_id')
                            <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Genre --}}
            <div class="bg-surface border border-white/[0.07] rounded-xl p-5">
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-3">Genre <span class="text-red-400">*</span></label>
                @error('genres')
                    <p class="mb-2 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                @enderror
                <div class="flex flex-wrap gap-2">
                    @foreach($genres as $genre)
                    @php
                        $checked = in_array($genre->id, old('genres', $film->genres->pluck('id')->toArray()));
                    @endphp
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                               {{ $checked ? 'checked' : '' }}
                               class="genre-check hidden">
                        <span class="genre-pill px-3 py-1.5 rounded-full border text-[12px] transition-colors select-none
                            {{ $checked ? 'border-[#c9a014] text-[#f5c518] bg-[rgba(245,197,24,0.08)]' : 'border-white/[0.10] text-gray-400' }}">
                            {{ $genre->name }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="flex flex-col gap-4">

            {{-- Poster --}}
            <div class="bg-surface border border-white/[0.07] rounded-xl p-5">
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-3">Poster Film</label>

                {{-- Current poster --}}
                @if($film->poster)
                <div class="mb-3 relative group">
                    <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->title }}"
                         class="w-full max-h-52 object-contain rounded-lg border border-white/[0.07]">
                    <div class="absolute inset-0 bg-black/50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-[12px] text-white">Klik area di bawah untuk ganti poster</span>
                    </div>
                </div>
                @endif

                <div id="drop-zone"
                     class="border-2 border-dashed border-white/[0.12] rounded-xl flex flex-col items-center justify-center p-4 cursor-pointer hover:border-[#c9a014] transition-colors">
                    <img id="poster-preview" src="" alt="" class="hidden w-full max-h-48 object-contain rounded-lg mb-2">
                    <div id="drop-placeholder" class="text-center">
                        <i class="ti ti-photo-up text-2xl text-gray-500 block mb-1.5"></i>
                        <p class="text-[12px] text-gray-400">{{ $film->poster ? 'Ganti poster' : 'Upload poster' }}</p>
                        <p class="text-[11px] text-gray-600 mt-0.5">JPEG, PNG, JPG — maks. 2MB</p>
                    </div>
                    <input type="file" name="poster" id="poster-input" accept="image/jpeg,image/png,image/jpg" class="hidden">
                </div>
                <p class="mt-1.5 text-[11px] text-gray-600">Biarkan kosong jika tidak ingin mengganti poster.</p>
            </div>

            {{-- Tahun --}}
            <div class="bg-surface border border-white/[0.07] rounded-xl p-5">
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Tahun Rilis <span class="text-red-400">*</span></label>
                <input type="number" name="year" value="{{ old('year', $film->year) }}"
                       min="1950" max="{{ date('Y') + 2 }}"
                       class="w-full bg-surface-2 border @error('year') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[14px] text-gray-100 outline-none focus:border-[#c9a014] transition-colors font-sans">
                @error('year')
                    <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- ACTIONS --}}
            <div class="flex flex-col gap-2.5">
                <button type="submit"
                        class="w-full bg-[#f5c518] hover:bg-[#c9a014] text-black font-medium py-3 rounded-xl text-[14px] transition-colors flex items-center justify-center gap-2">
                    <i class="ti ti-device-floppy text-base"></i> Update Film
                </button>
                <a href="{{ route('admin.films.index') }}"
                   class="w-full border border-white/[0.07] hover:border-white/20 text-gray-400 hover:text-gray-200 py-3 rounded-xl text-[14px] transition-colors flex items-center justify-center gap-2">
                    <i class="ti ti-arrow-left text-base"></i> Batal
                </a>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    // ── GENRE PILL TOGGLE ──────────────────────────────────────────────
    document.querySelectorAll('label:has(.genre-check)').forEach(label => {
        label.addEventListener('click', () => {
            const cb   = label.querySelector('.genre-check');
            const pill = label.querySelector('.genre-pill');
            cb.checked = !cb.checked;
            pill.classList.toggle('border-[#c9a014]', cb.checked);
            pill.classList.toggle('text-[#f5c518]',   cb.checked);
            pill.classList.toggle('bg-[rgba(245,197,24,0.08)]', cb.checked);
            pill.classList.toggle('border-white/[0.10]', !cb.checked);
            pill.classList.toggle('text-gray-400', !cb.checked);
        });
    });

    // ── POSTER PREVIEW ─────────────────────────────────────────────────
    const dropZone    = document.getElementById('drop-zone');
    const posterInput = document.getElementById('poster-input');
    const preview     = document.getElementById('poster-preview');
    const placeholder = document.getElementById('drop-placeholder');

    dropZone.addEventListener('click', () => posterInput.click());
    posterInput.addEventListener('change', e => showPreview(e.target.files[0]));
    dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.classList.add('border-[#c9a014]'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-[#c9a014]'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('border-[#c9a014]');
        const file = e.dataTransfer.files[0];
        if (file) { posterInput.files = e.dataTransfer.files; showPreview(file); }
    });
    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.classList.remove('hidden'); placeholder.classList.add('hidden'); };
        reader.readAsDataURL(file);
    }

    // ── AJAX PROVINCE → REGENCY ────────────────────────────────────────
    const provinceSelect = document.getElementById('province-select');
    const regencySelect  = document.getElementById('regency-select');
    const currentRegency = "{{ old('regency_id', $film->regency_id) }}";

    function loadRegencies(provinceId, selectValue = null) {
        if (!provinceId) { regencySelect.innerHTML = '<option value="">— Pilih Provinsi dulu —</option>'; return; }
        regencySelect.innerHTML = '<option value="">Memuat...</option>';
        regencySelect.disabled  = true;
        fetch(`/admin/regencies/${provinceId}`)
            .then(r => r.json())
            .then(data => {
                regencySelect.innerHTML = '<option value="">— Pilih Kabupaten/Kota —</option>';
                data.forEach(r => {
                    const opt     = document.createElement('option');
                    opt.value     = r.id;
                    opt.textContent = r.name;
                    if (selectValue && r.id == selectValue) opt.selected = true;
                    regencySelect.appendChild(opt);
                });
                regencySelect.disabled = false;
            });
    }

    provinceSelect.addEventListener('change', function () { loadRegencies(this.value); });

    // Auto-load pada page load (untuk edit)
    const currentProvince = provinceSelect.value;
    if (currentProvince) loadRegencies(currentProvince, currentRegency);
</script>
@endpush
