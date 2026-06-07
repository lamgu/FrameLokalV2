@extends('layouts.user')

@section('title', 'Beranda')

@section('content')

<!-- ═══════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════ -->
<section id="hero" class="relative h-[88vh] min-h-[560px] flex items-end overflow-hidden bg-[#0a0a0a]">

    <!-- Hero Background -->
    <div id="hero-bg" class="absolute inset-0 bg-cover bg-center transition-all duration-700" style="background-image: none;"></div>
    <div class="hero-gradient absolute inset-0"></div>

    <!-- Hero Skeleton (shown while loading) -->
    <div id="hero-skeleton" class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8 pb-16">
        <div class="max-w-xl space-y-4">
            <div class="skeleton h-4 w-36 rounded-full"></div>
            <div class="skeleton h-12 w-80 rounded-xl"></div>
            <div class="skeleton h-4 w-full rounded-full"></div>
            <div class="skeleton h-4 w-3/4 rounded-full"></div>
            <div class="flex gap-3 mt-6">
                <div class="skeleton h-11 w-40 rounded-xl"></div>
                <div class="skeleton h-11 w-40 rounded-xl"></div>
            </div>
        </div>
    </div>

    <!-- Hero Content (hidden until data loads) -->
    <div id="hero-content" class="hidden relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8 pb-16">
        <div class="max-w-2xl">
            <!-- Genres badge -->
            <div id="hero-genres" class="flex flex-wrap gap-2 mb-4"></div>

            <!-- Title -->
            <h1 id="hero-title" class="font-display text-5xl sm:text-7xl tracking-wide text-white leading-none mb-4"></h1>

            <!-- Meta row: year + rating -->
            <div class="flex items-center gap-4 mb-4">
                <span id="hero-year" class="text-sm text-gray-400 font-medium"></span>
                <div id="hero-stars" class="flex gap-0.5"></div>
                <span id="hero-rating-text" class="text-sm font-semibold text-[#f5c518]"></span>
                <span id="hero-location" class="text-sm text-gray-400"></span>
            </div>

            <!-- Synopsis -->
            <p id="hero-synopsis" class="text-gray-300 text-sm sm:text-base leading-relaxed max-w-lg line-clamp-3 mb-7"></p>

            <!-- CTAs -->
            <div class="flex flex-wrap gap-3">
                <button id="hero-btn-watch" class="flex items-center gap-2 bg-[#f5c518] hover:bg-[#c9a014] text-black font-semibold px-6 py-3 rounded-xl transition-all duration-200 shadow-lg shadow-[#f5c518]/20 hover:shadow-[#f5c518]/40">
                    <i class="ti ti-player-play-filled text-lg"></i>
                    Tonton Sekarang
                </button>
                <button id="hero-btn-info" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3 rounded-xl backdrop-blur-sm transition-all duration-200 border border-white/10">
                    <i class="ti ti-info-circle text-lg"></i>
                    Info Lebih Lanjut
                </button>
            </div>
        </div>
    </div>

    <!-- Hero Error -->
    <div id="hero-error" class="hidden relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8 pb-16 text-gray-500 text-sm">
        <i class="ti ti-alert-circle mr-2"></i>Gagal memuat film unggulan.
    </div>
</section>

<!-- ═══════════════════════════════════════════
     FILM TERBARU
═══════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-6 lg:px-8 mt-16">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-display text-2xl sm:text-3xl tracking-wide text-white">Film Terbaru</h2>
        <a href="#" class="text-xs text-[#f5c518] hover:text-[#c9a014] font-medium transition-colors flex items-center gap-1">
            Lihat Semua <i class="ti ti-arrow-right text-sm"></i>
        </a>
    </div>

    <!-- Loading -->
    <div id="latest-skeleton" class="flex gap-4">
        @for ($i = 0; $i < 6; $i++)
        <div class="flex-shrink-0 w-36 sm:w-44">
            <div class="skeleton rounded-xl" style="padding-top: 150%;"></div>
            <div class="skeleton h-3 w-3/4 rounded-full mt-3"></div>
            <div class="skeleton h-3 w-1/2 rounded-full mt-2"></div>
        </div>
        @endfor
    </div>

    <!-- Carousel -->
    <div id="latest-row" class="hidden film-row flex gap-4 pb-2"></div>

    <!-- Error -->
    <div id="latest-error" class="hidden py-8 text-center text-gray-600 text-sm">
        <i class="ti ti-wifi-off text-2xl block mb-2"></i>
        Gagal memuat film terbaru. <button onclick="fetchLatest()" class="text-[#f5c518] underline ml-1">Coba lagi</button>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     FILM RATING TINGGI
═══════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-6 lg:px-8 mt-14">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="font-display text-2xl sm:text-3xl tracking-wide text-white">Rating Tertinggi</h2>
            <p class="text-xs text-gray-500 mt-0.5">Film dengan ulasan terbaik dari penonton</p>
        </div>
        <a href="#" class="text-xs text-[#f5c518] hover:text-[#c9a014] font-medium transition-colors flex items-center gap-1">
            Lihat Semua <i class="ti ti-arrow-right text-sm"></i>
        </a>
    </div>

    <!-- Loading -->
    <div id="toprated-skeleton" class="flex gap-4">
        @for ($i = 0; $i < 6; $i++)
        <div class="flex-shrink-0 w-36 sm:w-44">
            <div class="skeleton rounded-xl" style="padding-top: 150%;"></div>
            <div class="skeleton h-3 w-3/4 rounded-full mt-3"></div>
            <div class="skeleton h-3 w-1/2 rounded-full mt-2"></div>
        </div>
        @endfor
    </div>

    <!-- Carousel -->
    <div id="toprated-row" class="hidden film-row flex gap-4 pb-2"></div>

    <!-- Error -->
    <div id="toprated-error" class="hidden py-8 text-center text-gray-600 text-sm">
        <i class="ti ti-wifi-off text-2xl block mb-2"></i>
        Gagal memuat film rating tinggi. <button onclick="fetchTopRated()" class="text-[#f5c518] underline ml-1">Coba lagi</button>
    </div>
</section>

<!-- Spacer -->
<div class="h-16"></div>

@endsection

@push('scripts')
<script>
// ─────────────────────────────────────────
// Helpers
// ─────────────────────────────────────────

function renderStars(rating) {
    const full  = Math.floor(rating);
    const half  = (rating - full) >= 0.5 ? 1 : 0;
    const empty = 5 - full - half;
    let html = '';
    for (let i = 0; i < full;  i++) html += '<i class="ti ti-star-filled star" style="font-size:13px;color:#f5c518"></i>';
    if (half)                        html += '<i class="ti ti-star-half-filled star" style="font-size:13px;color:#f5c518"></i>';
    for (let i = 0; i < empty; i++) html += '<i class="ti ti-star star-empty" style="font-size:13px;color:#444"></i>';
    return html;
}

function posterSrc(film) {
    return film.poster_url || `https://placehold.co/300x450/1a1a1a/444444?text=${encodeURIComponent(film.title)}`;
}

function filmCard(film) {
    const rating = film.rating ? Number(film.rating).toFixed(1) : '–';
    const genreLabel = film.genres && film.genres.length ? film.genres.slice(0,2).join(', ') : '';
    const detailUrl = `/film/${film.slug || film.id}`;
    return `
    <div class="film-card w-36 sm:w-44 select-none">
        <div class="relative rounded-xl overflow-hidden bg-[#1a1a1a] cursor-pointer group" style="aspect-ratio: 2/3;" onclick="window.location.href='${detailUrl}'">
            <img src="${posterSrc(film)}" alt="${film.title}"
                 class="film-poster w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                 loading="lazy"
                 onerror="this.src='https://placehold.co/300x450/1a1a1a/444444?text=${encodeURIComponent(film.title)}'">
            <div class="film-overlay absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent flex flex-col justify-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                <div class="flex items-center gap-1 mb-1">
                    <i class="ti ti-star-filled" style="color:#f5c518;font-size:11px"></i>
                    <span class="text-xs font-bold text-[#f5c518]">${rating}</span>
                </div>
                <p class="text-[11px] text-gray-300 leading-tight">${genreLabel}</p>
                <button class="mt-2 w-full bg-[#f5c518] hover:bg-[#c9a014] text-black text-xs font-bold py-1.5 rounded-lg transition-colors">
                    <i class="ti ti-info-circle mr-0.5"></i> Detail
                </button>
            </div>
        </div>
        <p class="mt-2 text-[13px] font-medium text-white leading-tight truncate cursor-pointer hover:text-[#f5c518] transition-colors" onclick="window.location.href='${detailUrl}'">${film.title}</p>
        <p class="text-[11px] text-gray-500 mt-0.5">${film.year ?? ''}${film.location ? ' · ' + film.location : ''}</p>
    </div>`;
}

// ─────────────────────────────────────────
// HERO
// ─────────────────────────────────────────

async function fetchHero() {
    try {
        const res = await fetch('/api/films/featured');
        if (!res.ok) throw new Error('HTTP ' + res.status);

        // 204 No Content = no films yet
        if (res.status === 204) {
            document.getElementById('hero-skeleton').classList.add('hidden');
            document.getElementById('hero-error').classList.remove('hidden');
            return;
        }

        const film = await res.json();

        // Background
        const bg = document.getElementById('hero-bg');
        if (film.poster_url) {
            bg.style.backgroundImage = `url('${film.poster_url}')`;
        }

        // Genres
        const genresEl = document.getElementById('hero-genres');
        genresEl.innerHTML = '';
        (film.genres || []).forEach(g => {
            const span = document.createElement('span');
            span.className = 'text-[10px] font-semibold uppercase tracking-widest px-2.5 py-1 rounded-full bg-[#f5c518]/15 text-[#f5c518] border border-[#f5c518]/20';
            span.textContent = g;
            genresEl.appendChild(span);
        });

        // Fill data
        document.getElementById('hero-title').textContent    = film.title;
        document.getElementById('hero-year').textContent     = film.year ?? '';
        document.getElementById('hero-synopsis').textContent = film.synopsis ?? '';
        document.getElementById('hero-stars').innerHTML      = renderStars(film.rating ?? 0);
        document.getElementById('hero-rating-text').textContent = film.rating ? '★ ' + Number(film.rating).toFixed(1) : '';
        document.getElementById('hero-location').textContent = film.location ? '📍 ' + film.location : '';

        // Bind clicks to details page
        const detailUrl = `/film/${film.slug || film.id}`;
        document.getElementById('hero-btn-watch').onclick = () => window.location.href = detailUrl;
        document.getElementById('hero-btn-info').onclick = () => window.location.href = detailUrl;

        // Show
        document.getElementById('hero-skeleton').classList.add('hidden');
        document.getElementById('hero-content').classList.remove('hidden');

    } catch (e) {
        console.error('Hero fetch error:', e);
        document.getElementById('hero-skeleton').classList.add('hidden');
        document.getElementById('hero-error').classList.remove('hidden');
    }
}

// ─────────────────────────────────────────
// LATEST
// ─────────────────────────────────────────

async function fetchLatest() {
    const skeleton = document.getElementById('latest-skeleton');
    const row      = document.getElementById('latest-row');
    const errEl    = document.getElementById('latest-error');

    skeleton.classList.remove('hidden');
    row.classList.add('hidden');
    errEl.classList.add('hidden');
    row.innerHTML = '';

    try {
        const res   = await fetch('/api/films/latest?limit=12');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const films = await res.json();

        if (!films.length) {
            skeleton.classList.add('hidden');
            errEl.innerHTML = '<p class="text-gray-600 text-sm py-8 text-center">Belum ada film tersedia.</p>';
            errEl.classList.remove('hidden');
            return;
        }

        row.innerHTML = films.map(filmCard).join('');
        skeleton.classList.add('hidden');
        row.classList.remove('hidden');

    } catch (e) {
        console.error('Latest fetch error:', e);
        skeleton.classList.add('hidden');
        errEl.classList.remove('hidden');
    }
}

// ─────────────────────────────────────────
// TOP-RATED
// ─────────────────────────────────────────

async function fetchTopRated() {
    const skeleton = document.getElementById('toprated-skeleton');
    const row      = document.getElementById('toprated-row');
    const errEl    = document.getElementById('toprated-error');

    skeleton.classList.remove('hidden');
    row.classList.add('hidden');
    errEl.classList.add('hidden');
    row.innerHTML = '';

    try {
        const res   = await fetch('/api/films/top-rated?limit=12');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const films = await res.json();

        if (!films.length) {
            skeleton.classList.add('hidden');
            errEl.innerHTML = '<p class="text-gray-600 text-sm py-8 text-center">Belum ada film tersedia.</p>';
            errEl.classList.remove('hidden');
            return;
        }

        row.innerHTML = films.map(filmCard).join('');
        skeleton.classList.add('hidden');
        row.classList.remove('hidden');

    } catch (e) {
        console.error('Top-rated fetch error:', e);
        skeleton.classList.add('hidden');
        errEl.classList.remove('hidden');
    }
}

// ─────────────────────────────────────────
// Bootstrap — run all on page load
// ─────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
    fetchHero();
    fetchLatest();
    fetchTopRated();
});
</script>
@endpush
