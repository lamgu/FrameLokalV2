@extends('layouts.admin')

@section('title', 'Kelola Film')
@section('page-title', 'Kelola Film')

@section('content')

{{-- HEADER ROW --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-400 text-sm">Total <span class="text-[#f5c518] font-medium">{{ $films->count() }}</span> film terdaftar</p>
    </div>
    <a href="{{ route('admin.films.create') }}"
       class="flex items-center gap-2 bg-[#f5c518] hover:bg-[#c9a014] text-black text-sm font-medium px-4 py-2.5 rounded-lg transition-colors">
        <i class="ti ti-plus text-base"></i> Tambah Film
    </a>
</div>

{{-- FILTER BAR --}}
<div class="bg-surface border border-white/[0.07] rounded-xl px-5 py-4 mb-5 flex items-center gap-4">
    <div class="flex items-center gap-2 bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-2 flex-1 max-w-xs">
        <i class="ti ti-search text-gray-500 text-sm"></i>
        <input type="text" id="search-input" placeholder="Cari judul film..."
               class="bg-transparent border-none outline-none text-[13px] text-gray-100 placeholder-gray-500 w-full font-sans">
    </div>
    <select id="genre-filter" class="bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-2 text-[13px] text-gray-300 outline-none font-sans cursor-pointer">
        <option value="">Semua Genre</option>
        @foreach($genres as $genre)
            <option value="{{ $genre->name }}">{{ $genre->name }}</option>
        @endforeach
    </select>
    <select id="year-filter" class="bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-2 text-[13px] text-gray-300 outline-none font-sans cursor-pointer">
        <option value="">Semua Tahun</option>
        @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
        @endforeach
    </select>
</div>

{{-- TABLE --}}
<div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
    <table class="w-full" id="films-table">
        <thead>
            <tr class="border-b border-white/[0.07]">
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">#</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Film</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Genre</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Lokasi</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Tahun</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Rating</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($films as $index => $film)
            <tr class="film-row border-b border-white/[0.04] hover:bg-surface-2 transition-colors"
                data-title="{{ strtolower($film->title) }}"
                data-genre="{{ $film->genres->pluck('name')->join(',') }}"
                data-year="{{ $film->year }}">
                <td class="px-5 py-3 text-[13px] text-gray-500">{{ $index + 1 }}</td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-[52px] rounded bg-surface-3 border border-white/[0.07] flex-shrink-0 overflow-hidden">
                            @if($film->poster)
                                <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="ti ti-photo text-gray-600 text-xs"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-[13px] font-medium text-gray-100">{{ $film->title }}</p>
                            <p class="text-[11px] text-gray-500 font-mono">{{ $film->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3">
                    <div class="flex flex-wrap gap-1">
                        @foreach($film->genres as $genre)
                            <x-admin.genre-badge :genre="$genre->name" />
                        @endforeach
                    </div>
                </td>
                <td class="px-5 py-3">
                    <p class="text-[13px] text-gray-300">{{ $film->regency->name ?? '-' }}</p>
                    <p class="text-[11px] text-gray-500">{{ $film->regency->province->name ?? '-' }}</p>
                </td>
                <td class="px-5 py-3 text-[13px] text-gray-300">{{ $film->year }}</td>
                <td class="px-5 py-3">
                    <x-admin.star-rating :rating="$film->rating" />
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-1.5">
                        <a href="{{ route('admin.films.edit', $film) }}"
                           title="Edit Film"
                           class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-[#f5c518] hover:border-[#c9a014] transition-colors">
                            <i class="ti ti-edit text-sm"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.films.destroy', $film) }}"
                              onsubmit="return confirm('Yakin ingin menghapus film \'{{ addslashes($film->title) }}\'?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    title="Hapus Film"
                                    class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-red-400 hover:border-red-500/40 transition-colors">
                                <i class="ti ti-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-5 py-16 text-center">
                    <i class="ti ti-movie-off text-3xl text-gray-600 block mb-3"></i>
                    <p class="text-gray-500 text-sm">Belum ada film. <a href="{{ route('admin.films.create') }}" class="text-[#f5c518] hover:underline">Tambah sekarang</a></p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Empty search state --}}
    <div id="no-results" class="hidden px-5 py-16 text-center">
        <i class="ti ti-search-off text-3xl text-gray-600 block mb-3"></i>
        <p class="text-gray-500 text-sm">Tidak ada film yang cocok dengan pencarian.</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Client-side filter tanpa reload halaman
    const searchInput  = document.getElementById('search-input');
    const genreFilter  = document.getElementById('genre-filter');
    const yearFilter   = document.getElementById('year-filter');
    const rows         = document.querySelectorAll('.film-row');
    const noResults    = document.getElementById('no-results');

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const genre  = genreFilter.value.toLowerCase();
        const year   = yearFilter.value;
        let visible  = 0;

        rows.forEach(row => {
            const matchTitle = row.dataset.title.includes(search);
            const matchGenre = !genre || row.dataset.genre.toLowerCase().includes(genre);
            const matchYear  = !year  || row.dataset.year === year;
            const show = matchTitle && matchGenre && matchYear;
            row.classList.toggle('hidden', !show);
            if (show) visible++;
        });

        noResults.classList.toggle('hidden', visible > 0);
    }

    searchInput.addEventListener('input', filterTable);
    genreFilter.addEventListener('change', filterTable);
    yearFilter.addEventListener('change', filterTable);
</script>
@endpush
