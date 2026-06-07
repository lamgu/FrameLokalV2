@extends('layouts.user')

@section('title', 'Eksplorasi Film')

@section('content')

{{-- ══════════════════════════════════
     HERO HEADER
══════════════════════════════════ --}}
<div class="relative pt-24 pb-10 px-6 lg:px-8 bg-gradient-to-b from-[#0a0a0a] to-transparent">
    <div class="max-w-7xl mx-auto">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#f5c518] mb-2">Frame Lokal</p>
        <h1 class="font-display text-4xl sm:text-5xl text-white tracking-wide mb-1">Eksplorasi Film</h1>
        <p class="text-gray-500 text-sm">Temukan film lokal Indonesia terbaik sesuai selera Anda</p>
    </div>
</div>

{{-- ══════════════════════════════════
     FILTER BAR
══════════════════════════════════ --}}
<div class="sticky top-16 z-40 bg-[#0a0a0a]/95 backdrop-blur-md border-b border-white/[0.06] py-4">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">

            {{-- Search --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                    <i class="ti ti-search text-gray-500 text-base"></i>
                </div>
                <input
                    id="search-input"
                    type="text"
                    placeholder="Cari judul film..."
                    autocomplete="off"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-[#1a1a1a] text-white text-sm border border-white/[0.07]
                           focus:outline-none focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] transition-colors
                           placeholder-gray-600"
                >
                {{-- Clear button --}}
                <button id="search-clear"
                    class="hidden absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-white transition-colors">
                    <i class="ti ti-x text-sm"></i>
                </button>
            </div>

            {{-- Sort --}}
            <select id="sort-select"
                class="px-4 py-2.5 rounded-xl bg-[#1a1a1a] text-white text-sm border border-white/[0.07]
                       focus:outline-none focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] transition-colors
                       cursor-pointer">
                <option value="latest">Terbaru</option>
                <option value="rating">Rating Tertinggi</option>
                <option value="year">Tahun Terbaru</option>
            </select>
        </div>

        {{-- Genre Pills --}}
        <div class="mt-3 flex gap-2 overflow-x-auto pb-1" style="scrollbar-width:none;">
            <button data-genre="" class="genre-pill active flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold
                   transition-all duration-200 border">
                Semua Genre
            </button>
            {{-- Dynamic genre pills injected by JS --}}
            <div id="genre-pills-container" class="flex gap-2"></div>
        </div>

        {{-- Result count --}}
        <div class="mt-3 flex items-center gap-2">
            <div id="result-info" class="text-xs text-gray-600"></div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════
     FILM GRID
══════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">

    {{-- Skeleton Grid --}}
    <div id="grid-skeleton" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @for ($i = 0; $i < 15; $i++)
        <div>
            <div class="skeleton rounded-xl w-full" style="aspect-ratio:2/3;"></div>
            <div class="skeleton h-3 w-3/4 rounded-full mt-3"></div>
            <div class="skeleton h-3 w-1/2 rounded-full mt-2"></div>
        </div>
        @endfor
    </div>

    {{-- Film Grid --}}
    <div id="film-grid" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-7">
    </div>

    {{-- Empty State --}}
    <div id="empty-state" class="hidden flex flex-col items-center justify-center py-24 text-center">
        <div class="w-16 h-16 rounded-2xl bg-[#1a1a1a] border border-white/[0.07] flex items-center justify-center mb-4">
            <i class="ti ti-movie-off text-2xl text-gray-600"></i>
        </div>
        <h3 class="text-white font-semibold mb-1">Tidak ada film ditemukan</h3>
        <p id="empty-msg" class="text-gray-500 text-sm max-w-xs">
            Coba ubah kata kunci pencarian atau pilih genre yang berbeda.
        </p>
        <button onclick="resetFilters()"
            class="mt-5 px-5 py-2 rounded-xl bg-[#f5c518] hover:bg-[#c9a014] text-black text-sm font-semibold transition-colors">
            Reset Filter
        </button>
    </div>

    {{-- Error State --}}
    <div id="error-state" class="hidden flex flex-col items-center justify-center py-24 text-center">
        <i class="ti ti-wifi-off text-4xl text-gray-700 mb-3"></i>
        <h3 class="text-white font-semibold mb-1">Gagal memuat data</h3>
        <p class="text-gray-500 text-sm mb-5">Periksa koneksi internet Anda dan coba lagi.</p>
        <button onclick="fetchFilms()"
            class="px-5 py-2 rounded-xl bg-[#f5c518] hover:bg-[#c9a014] text-black text-sm font-semibold transition-colors">
            Coba Lagi
        </button>
    </div>

    {{-- Load More --}}
    <div id="load-more-wrap" class="hidden flex justify-center mt-10">
        <button id="load-more-btn" onclick="loadMore()"
            class="flex items-center gap-2 px-8 py-3 rounded-xl border border-white/10 hover:border-[#f5c518]/40
                   text-sm text-gray-300 hover:text-[#f5c518] font-medium transition-all duration-200">
            <i class="ti ti-arrow-down text-base"></i>
            Muat Lebih Banyak
        </button>
    </div>
</div>

@endsection

@push('styles')
<style>
.genre-pill {
    background: transparent;
    border-color: rgba(255,255,255,0.08);
    color: #9ca3af;
}
.genre-pill:hover {
    border-color: rgba(245,197,24,0.3);
    color: #ffffff;
}
.genre-pill.active {
    background: #f5c518;
    border-color: #f5c518;
    color: #000000;
}

/* Film card hover */
.film-grid-card .overlay { opacity: 0; transition: opacity 0.25s ease; }
.film-grid-card:hover .overlay { opacity: 1; }
.film-grid-card .poster { transition: transform 0.3s ease; }
.film-grid-card:hover .poster { transform: scale(1.03); }

/* Rating stars */
.star-icon { color: #f5c518; font-size: 11px; }
.star-empty { color: #3a3a3a; font-size: 11px; }
</style>
@endpush

@push('scripts')
<script>
// ──────────────────────────────────────────
// STATE
// ──────────────────────────────────────────
const state = {
    search:   '',
    genreId:  '',
    sort:     'latest',
    page:     1,
    lastPage: 1,
    loading:  false,
};

// ──────────────────────────────────────────
// HELPERS
// ──────────────────────────────────────────
function stars(rating) {
    const r = Number(rating) || 0;
    const full  = Math.floor(r);
    const half  = r - full >= 0.5 ? 1 : 0;
    const empty = 5 - full - half;
    let h = '';
    for (let i=0; i < full;  i++) h += '<i class="ti ti-star-filled star-icon"></i>';
    if (half)                      h += '<i class="ti ti-star-half-filled star-icon"></i>';
    for (let i=0; i < empty; i++) h += '<i class="ti ti-star star-empty"></i>';
    return h;
}

function posterSrc(film) {
    return film.poster_url
        || `https://placehold.co/300x450/1a1a1a/333333?text=${encodeURIComponent(film.title)}`;
}

function filmCardHTML(film) {
    const rating  = film.rating ? Number(film.rating).toFixed(1) : '–';
    const year    = film.year ?? '';
    const loc     = film.location ?? '';
    const meta    = [year, loc].filter(Boolean).join(' · ');
    const genres  = film.genres ? film.genres.slice(0,2).join(', ') : '';
    const detailUrl = `/film/${film.slug || film.id}`;
    return `
    <div class="film-grid-card group cursor-pointer select-none">
        <div class="relative rounded-xl overflow-hidden bg-[#1a1a1a]" style="aspect-ratio:2/3;" onclick="window.location.href='${detailUrl}'">
            <img src="${posterSrc(film)}"
                 alt="${film.title}"
                 class="poster w-full h-full object-cover"
                 loading="lazy"
                 onerror="this.src='https://placehold.co/300x450/1a1a1a/333333?text=${encodeURIComponent(film.title)}'">

            {{-- Overlay --}}
            <div class="overlay absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent
                        flex flex-col justify-end p-3 gap-1.5">
                <div class="flex items-center gap-1 flex-wrap">
                    ${stars(film.rating)}
                    <span class="text-[11px] font-bold text-[#f5c518] ml-1">${rating}</span>
                </div>
                <p class="text-[11px] text-gray-300 leading-tight truncate">${genres}</p>
                <button class="w-full mt-1 bg-[#f5c518] hover:bg-[#c9a014] text-black text-xs font-bold
                               py-1.5 rounded-lg transition-colors flex items-center justify-center gap-1">
                    <i class="ti ti-info-circle text-xs"></i> Detail
                </button>
            </div>

            {{-- Top badge: rating --}}
            <div class="absolute top-2 right-2 flex items-center gap-0.5
                        bg-black/70 backdrop-blur-sm px-2 py-0.5 rounded-full">
                <i class="ti ti-star-filled" style="color:#f5c518;font-size:10px;"></i>
                <span class="text-[10px] text-white font-bold">${rating}</span>
            </div>
        </div>
        <p class="mt-2 text-[13px] font-medium text-white leading-tight line-clamp-1 cursor-pointer hover:text-[#f5c518] transition-colors" onclick="window.location.href='${detailUrl}'">${film.title}</p>
        <p class="text-[11px] text-gray-500 mt-0.5">${meta}</p>
    </div>`;
}

// ──────────────────────────────────────────
// UI STATE TOGGLES
// ──────────────────────────────────────────
function showSkeleton()  {
    document.getElementById('grid-skeleton').classList.remove('hidden');
    document.getElementById('film-grid').classList.add('hidden');
    document.getElementById('empty-state').classList.add('hidden');
    document.getElementById('error-state').classList.add('hidden');
    document.getElementById('load-more-wrap').classList.add('hidden');
}
function hideSkeleton()  { document.getElementById('grid-skeleton').classList.add('hidden'); }

function showGrid(html, append = false) {
    const grid = document.getElementById('film-grid');
    if (append) grid.innerHTML += html;
    else        grid.innerHTML  = html;
    grid.classList.remove('hidden');
}
function showEmpty(msg) {
    document.getElementById('empty-msg').textContent = msg || 'Tidak ada film yang cocok dengan filter Anda.';
    document.getElementById('empty-state').classList.remove('hidden');
}
function showError() {
    document.getElementById('error-state').classList.remove('hidden');
}

// ──────────────────────────────────────────
// FETCH FILMS
// ──────────────────────────────────────────
async function fetchFilms(append = false) {
    if (state.loading) return;
    state.loading = true;

    if (!append) {
        showSkeleton();
        state.page = 1;
    }

    const params = new URLSearchParams({
        sort:     state.sort,
        per_page: 20,
        page:     state.page,
    });
    if (state.search)  params.set('search',   state.search);
    if (state.genreId) params.set('genre_id', state.genreId);

    try {
        const res  = await fetch(`/api/films/explore?${params}`);
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();

        hideSkeleton();
        state.lastPage = data.last_page;

        // Result count
        const info = document.getElementById('result-info');
        info.textContent = data.total
            ? `${data.total} film ditemukan`
            : '';

        if (!data.data.length && !append) {
            const msg = state.search
                ? `Tidak ada film dengan judul "${state.search}".`
                : 'Tidak ada film untuk genre ini.';
            showEmpty(msg);
        } else {
            const html = data.data.map(filmCardHTML).join('');
            showGrid(html, append);
        }

        // Load more button
        const lmWrap = document.getElementById('load-more-wrap');
        if (state.page < state.lastPage) {
            lmWrap.classList.remove('hidden');
        } else {
            lmWrap.classList.add('hidden');
        }

    } catch (e) {
        console.error('Explore fetch error:', e);
        hideSkeleton();
        showError();
    } finally {
        state.loading = false;
    }
}

function loadMore() {
    state.page++;
    fetchFilms(true);
}

// ──────────────────────────────────────────
// FETCH GENRES
// ──────────────────────────────────────────
async function fetchGenres() {
    try {
        const res    = await fetch('/api/genres');
        const genres = await res.json();
        const container = document.getElementById('genre-pills-container');
        container.innerHTML = genres.map(g => `
            <button data-genre="${g.id}"
                class="genre-pill flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold
                       transition-all duration-200 border">
                ${g.name}
            </button>
        `).join('');

        // Attach events to new pills
        document.querySelectorAll('.genre-pill').forEach(pill => {
            pill.addEventListener('click', () => selectGenre(pill));
        });
    } catch(e) {
        console.error('Genre fetch error:', e);
    }
}

// ──────────────────────────────────────────
// GENRE SELECTION
// ──────────────────────────────────────────
function selectGenre(pill) {
    document.querySelectorAll('.genre-pill').forEach(p => p.classList.remove('active'));
    pill.classList.add('active');
    state.genreId = pill.dataset.genre || '';
    fetchFilms();
}

// ──────────────────────────────────────────
// RESET
// ──────────────────────────────────────────
function resetFilters() {
    state.search  = '';
    state.genreId = '';
    state.sort    = 'latest';
    state.page    = 1;

    document.getElementById('search-input').value = '';
    document.getElementById('sort-select').value  = 'latest';
    document.querySelectorAll('.genre-pill').forEach(p => p.classList.remove('active'));
    document.querySelector('.genre-pill[data-genre=""]').classList.add('active');
    document.getElementById('search-clear').classList.add('hidden');

    fetchFilms();
}

// ──────────────────────────────────────────
// DEBOUNCE
// ──────────────────────────────────────────
function debounce(fn, delay) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
    };
}

// ──────────────────────────────────────────
// EVENT LISTENERS
// ──────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Initial loads
    fetchGenres();
    fetchFilms();

    // "Semua Genre" pill
    document.querySelector('.genre-pill[data-genre=""]').addEventListener('click', function() {
        selectGenre(this);
    });

    // Search input with debounce
    const searchInput = document.getElementById('search-input');
    const searchClear = document.getElementById('search-clear');

    searchInput.addEventListener('input', debounce(() => {
        state.search = searchInput.value.trim();
        searchClear.classList.toggle('hidden', !state.search);
        fetchFilms();
    }, 350));

    // Clear search
    searchClear.addEventListener('click', () => {
        searchInput.value = '';
        state.search      = '';
        searchClear.classList.add('hidden');
        searchInput.focus();
        fetchFilms();
    });

    // Sort change
    document.getElementById('sort-select').addEventListener('change', function() {
        state.sort = this.value;
        fetchFilms();
    });
});
</script>
@endpush
