@extends('layouts.user')

@section('title', 'Peta Film Indonesia')

@section('content')

{{-- ════════════════════════════════════════
     TOOLTIP (floating, follows cursor)
════════════════════════════════════════ --}}
<div id="map-tooltip"
     class="fixed z-50 pointer-events-none select-none opacity-0 transition-opacity duration-150"
     style="top:0;left:0;transform:translate(-50%,-110%)">
    <div class="bg-[#111] border border-[#f5c518]/40 rounded-lg px-3 py-1.5 shadow-xl shadow-black/60
                flex items-center gap-2 whitespace-nowrap">
        <i class="ti ti-map-pin text-[#f5c518] text-xs"></i>
        <span id="tooltip-text" class="text-white text-xs font-semibold"></span>
    </div>
    {{-- Arrow --}}
    <div class="flex justify-center -mt-px">
        <div class="w-2 h-2 bg-[#111] border-r border-b border-[#f5c518]/40 rotate-45"></div>
    </div>
</div>

{{-- ════════════════════════════════════════
     PAGE HEADER
════════════════════════════════════════ --}}
<div class="relative pt-24 pb-8 px-6 lg:px-8 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-[#f5c518]/5 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto relative">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#f5c518] mb-2">Jelajahi Nusantara</p>
        <h1 class="font-display text-4xl sm:text-6xl text-white tracking-wide mb-2">Peta Film Indonesia</h1>
        <p class="text-gray-500 text-sm max-w-lg">Klik provinsi di peta untuk menemukan film-film dari daerah tersebut. Setiap sudut Nusantara punya ceritanya sendiri.</p>
    </div>
</div>

{{-- ════════════════════════════════════════
     CONTROLS BAR
════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-6 lg:px-8 mb-6">
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

        {{-- Province dropdown --}}
        <div class="relative flex-1 max-w-xs">
            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                <i class="ti ti-map-2 text-[#f5c518] text-base"></i>
            </div>
            <select id="province-dropdown"
                    class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-[#111] text-white text-sm border border-white/[0.07]
                           focus:outline-none focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] transition-colors
                           cursor-pointer appearance-none">
                <option value="">— Pilih Provinsi —</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->name }}">{{ $province->name }}</option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-3.5 flex items-center pointer-events-none">
                <i class="ti ti-chevron-down text-gray-500 text-sm"></i>
            </div>
        </div>

        {{-- Active filter badge --}}
        <div id="active-filter" class="hidden items-center gap-2 px-3 py-2 bg-[#f5c518]/10 border border-[#f5c518]/20 rounded-xl">
            <i class="ti ti-map-pin text-[#f5c518] text-sm"></i>
            <span id="active-filter-name" class="text-[#f5c518] text-sm font-semibold"></span>
            <button onclick="clearFilter()" class="ml-1 text-[#f5c518]/60 hover:text-[#f5c518] transition-colors">
                <i class="ti ti-x text-sm"></i>
            </button>
        </div>

        {{-- Reset button --}}
        <button id="reset-btn" onclick="clearFilter()"
                class="hidden items-center gap-1.5 px-4 py-2.5 rounded-xl border border-white/[0.07] text-gray-400
                       hover:text-white hover:border-white/20 text-sm transition-colors">
            <i class="ti ti-refresh text-sm"></i>
            Reset
        </button>

    </div>
</div>

{{-- ════════════════════════════════════════
     MAP AREA
════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-6 lg:px-8 mb-12">
    <div class="relative bg-[#0d0d0d] border border-white/[0.06] rounded-2xl overflow-hidden shadow-2xl">

        {{-- Map legend --}}
        <div class="absolute top-4 right-4 z-10 flex flex-col gap-1.5 bg-[#111]/80 backdrop-blur-sm border border-white/[0.07] rounded-xl px-3 py-2.5">
            <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Keterangan</p>
            <div class="flex items-center gap-2">
                <div class="w-4 h-3 rounded-sm bg-[#2a2a2a] border border-white/10"></div>
                <span class="text-[11px] text-gray-400">Belum ada film</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-3 rounded-sm bg-[#f5c518]/70"></div>
                <span class="text-[11px] text-gray-400">Ada film</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-3 rounded-sm bg-[#f5c518]"></div>
                <span class="text-[11px] text-gray-400">Dipilih</span>
            </div>
        </div>

        {{-- Zoom controls --}}
        <div class="absolute bottom-4 right-4 z-10 flex flex-col gap-1.5">
            <button onclick="zoomIn()" class="w-8 h-8 bg-[#111]/80 backdrop-blur-sm border border-white/[0.07] rounded-lg flex items-center justify-center text-gray-400 hover:text-white hover:border-white/20 transition-colors">
                <i class="ti ti-plus text-sm"></i>
            </button>
            <button onclick="zoomOut()" class="w-8 h-8 bg-[#111]/80 backdrop-blur-sm border border-white/[0.07] rounded-lg flex items-center justify-center text-gray-400 hover:text-white hover:border-white/20 transition-colors">
                <i class="ti ti-minus text-sm"></i>
            </button>
            <button onclick="zoomReset()" class="w-8 h-8 bg-[#111]/80 backdrop-blur-sm border border-white/[0.07] rounded-lg flex items-center justify-center text-gray-400 hover:text-white hover:border-white/20 transition-colors">
                <i class="ti ti-maximize text-sm"></i>
            </button>
        </div>

        {{-- Hint text --}}
        <div class="absolute bottom-4 left-4 z-10">
            <p class="text-[11px] text-gray-600 flex items-center gap-1.5">
                <i class="ti ti-hand-click text-xs"></i>
                Klik provinsi untuk melihat film
            </p>
        </div>

        {{-- SVG MAP CONTAINER --}}
        <div id="map-container" class="w-full overflow-hidden" style="cursor:grab">
            <div id="map-zoom-wrapper" style="transform-origin:center center; transition:transform 0.3s ease;">
                {!! file_get_contents(resource_path('svg/petaindonesia.svg')) !!}
            </div>
        </div>

    </div>
</div>

{{-- ════════════════════════════════════════
     RESULTS SECTION
════════════════════════════════════════ --}}
<div id="results-section" class="max-w-7xl mx-auto px-6 lg:px-8 mb-20 hidden">

    {{-- Section heading --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-[#f5c518]"></span>
                <p class="text-xs font-semibold uppercase tracking-widest text-[#f5c518]">Film dari Daerah</p>
            </div>
            <h2 id="results-heading" class="font-display text-3xl sm:text-4xl tracking-wide text-white"></h2>
        </div>
        <div id="results-count-wrap" class="hidden">
            <span id="results-count" class="text-sm text-gray-500"></span>
        </div>
    </div>

    {{-- Loading skeleton --}}
    <div id="films-skeleton" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-7">
        @for ($i = 0; $i < 10; $i++)
        <div>
            <div class="skeleton w-full rounded-xl" style="aspect-ratio:2/3;"></div>
            <div class="skeleton h-3 w-3/4 rounded-full mt-3"></div>
            <div class="skeleton h-3 w-1/2 rounded-full mt-2"></div>
        </div>
        @endfor
    </div>

    {{-- Films grid --}}
    <div id="films-grid" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-7"></div>

    {{-- Empty state --}}
    <div id="films-empty" class="hidden flex flex-col items-center justify-center py-24 text-center">
        <div class="w-20 h-20 rounded-2xl bg-[#111] border border-white/[0.07] flex items-center justify-center mb-5">
            <i class="ti ti-movie-off text-3xl text-gray-700"></i>
        </div>
        <h3 class="text-white font-semibold text-lg mb-2">Belum Ada Film</h3>
        <p class="text-gray-500 text-sm max-w-xs" id="empty-msg">Belum ada film yang terdaftar dari daerah ini. Yuk nantikan karya sineas lokal berikutnya!</p>
        <button onclick="clearFilter()" class="mt-6 px-5 py-2 rounded-xl border border-white/10 text-gray-400 hover:text-white hover:border-white/20 text-sm transition-colors">
            Pilih Daerah Lain
        </button>
    </div>

    {{-- Error state --}}
    <div id="films-error" class="hidden flex flex-col items-center justify-center py-24 text-center">
        <i class="ti ti-wifi-off text-4xl text-gray-700 mb-3"></i>
        <p class="text-gray-500 text-sm mb-4">Gagal memuat data. Periksa koneksi Anda.</p>
        <button id="retry-btn" class="px-5 py-2 rounded-xl bg-[#f5c518] hover:bg-[#c9a014] text-black text-sm font-semibold transition-colors">
            Coba Lagi
        </button>
    </div>

</div>

@endsection

@push('styles')
<style>
/* ── SVG MAP STYLES ── */
#map-zoom-wrapper svg {
    width: 100%;
    height: auto;
    display: block;
    background: transparent;
}

/* All province paths */
#map-zoom-wrapper svg path {
    fill: #2a2a2a;
    stroke: #1a1a1a;
    stroke-width: 0.5px;
    cursor: pointer;
    transition: fill 0.2s ease, filter 0.2s ease;
}

/* Hover state */
#map-zoom-wrapper svg path:hover {
    fill: #f5c518 !important;
    filter: drop-shadow(0 0 6px rgba(245, 197, 24, 0.5));
}

/* Selected state */
#map-zoom-wrapper svg path.map-selected {
    fill: #f5c518 !important;
    filter: drop-shadow(0 0 8px rgba(245, 197, 24, 0.6));
}

/* Provinces with films */
#map-zoom-wrapper svg path.has-films {
    fill: rgba(245, 197, 24, 0.35);
}
#map-zoom-wrapper svg path.has-films:hover {
    fill: #f5c518 !important;
}

/* Drag cursor */
#map-container { cursor: grab; user-select: none; }
#map-container:active { cursor: grabbing; }

/* Film card */
.map-film-card { cursor: pointer; }
.map-film-card .poster-wrap { transition: transform 0.3s ease; overflow: hidden; }
.map-film-card:hover .poster-wrap { transform: scale(1.03); }
.map-film-card:hover .film-title  { color: #f5c518; }
.film-title { transition: color 0.2s ease; }

/* Tooltip */
#map-tooltip.visible { opacity: 1; }
</style>
@endpush

@push('scripts')
<script>
// ══════════════════════════════════════════
// PROVINCES WITH FILMS (from API on load)
// ══════════════════════════════════════════
let provincesWithFilms = new Set();
let selectedProvince   = null;
let zoomLevel          = 1;

// Mapping SVG name attribute → possible DB province names
// (SVG uses old/formal names, DB may vary)
const nameAliases = {
    'Jawa Barat':             ['Jawa Barat'],
    'Jawa Timur':             ['Jawa Timur'],
    'Jawa Tengah':            ['Jawa Tengah'],
    'Jakarta Raya':           ['Jakarta Raya', 'DKI Jakarta', 'Jakarta'],
    'Daerah Istimewa Yogyakarta': ['Yogyakarta', 'DI Yogyakarta'],
    'Aceh':                   ['Aceh', 'Nanggroe Aceh Darussalam'],
    'Bali':                   ['Bali'],
    'Sumatera Utara':         ['Sumatera Utara', 'Sumatra Utara'],
    'Sumatera Barat':         ['Sumatera Barat'],
    'Sumatera Selatan':       ['Sumatera Selatan'],
    'Sulawesi Selatan':       ['Sulawesi Selatan'],
    'Sulawesi Utara':         ['Sulawesi Utara'],
    'Kalimantan Barat':       ['Kalimantan Barat'],
    'Kalimantan Timur':       ['Kalimantan Timur'],
    'Kalimantan Selatan':     ['Kalimantan Selatan'],
    'Papua':                  ['Papua'],
    'Papua Barat':            ['Papua Barat'],
    'Nusa Tenggara Barat':    ['Nusa Tenggara Barat', 'NTB'],
    'Nusa Tenggara Timur':    ['Nusa Tenggara Timur', 'NTT'],
    'Maluku':                 ['Maluku'],
    'Maluku Utara':           ['Maluku Utara'],
};

function resolveProvinceName(svgName) {
    // Check aliases
    if (nameAliases[svgName]) {
        return nameAliases[svgName][0];
    }
    return svgName;
}

// ══════════════════════════════════════════
// LOAD WHICH PROVINCES HAVE FILMS
// ══════════════════════════════════════════
async function loadProvinceFilmStatus() {
    try {
        // Fetch a large page to know all provinces that have films
        const res  = await fetch('/api/films/explore?per_page=200&sort=latest');
        const data = await res.json();
        data.data.forEach(film => {
            if (film.location) {
                provincesWithFilms.add(film.location.trim());
            }
        });
        markProvincesOnMap();
    } catch (e) {
        console.warn('Could not load province status:', e);
    }
}

function markProvincesOnMap() {
    document.querySelectorAll('#map-zoom-wrapper svg path').forEach(path => {
        const svgName = path.getAttribute('name') || path.id || '';
        const aliases = nameAliases[svgName] || [svgName];
        const hasFilm = aliases.some(alias =>
            [...provincesWithFilms].some(p => p.toLowerCase().includes(alias.toLowerCase()) || alias.toLowerCase().includes(p.toLowerCase()))
        );
        if (hasFilm) {
            path.classList.add('has-films');
        }
    });
}

// ══════════════════════════════════════════
// TOOLTIP
// ══════════════════════════════════════════
const tooltip     = document.getElementById('map-tooltip');
const tooltipText = document.getElementById('tooltip-text');

function showTooltip(e, text) {
    tooltipText.textContent = text;
    tooltip.classList.add('visible');
    moveTooltip(e);
}

function moveTooltip(e) {
    tooltip.style.left = e.clientX + 'px';
    tooltip.style.top  = (e.clientY + window.scrollY) + 'px';
}

function hideTooltip() {
    tooltip.classList.remove('visible');
}

// ══════════════════════════════════════════
// SVG INTERACTION
// ══════════════════════════════════════════
function initMap() {
    const svg = document.querySelector('#map-zoom-wrapper svg');
    if (!svg) return;

    svg.querySelectorAll('path').forEach(path => {
        const svgName = path.getAttribute('name') || path.id || 'Provinsi';

        path.addEventListener('mouseenter', (e) => showTooltip(e, svgName));
        path.addEventListener('mousemove',  (e) => moveTooltip(e));
        path.addEventListener('mouseleave', hideTooltip);

        path.addEventListener('click', () => {
            const dbName = resolveProvinceName(svgName);
            selectProvince(svgName, dbName, path);
        });
    });
}

function selectProvince(svgName, dbName, clickedPath = null) {
    selectedProvince = { svgName, dbName };

    // Clear previous selection highlight
    document.querySelectorAll('#map-zoom-wrapper svg path.map-selected').forEach(p => {
        p.classList.remove('map-selected');
    });

    // Highlight clicked path (or find it by name)
    const targetPath = clickedPath || document.querySelector(`#map-zoom-wrapper svg path[name="${svgName}"]`);
    if (targetPath) targetPath.classList.add('map-selected');

    // Update UI
    const activeFilter = document.getElementById('active-filter');
    const activeFilterName = document.getElementById('active-filter-name');
    activeFilter.classList.remove('hidden');
    activeFilter.classList.add('flex');
    activeFilterName.textContent = svgName;

    document.getElementById('reset-btn').classList.remove('hidden');
    document.getElementById('reset-btn').classList.add('flex');

    // Sync dropdown
    const dropdown = document.getElementById('province-dropdown');
    // Find the option that matches dbName
    Array.from(dropdown.options).forEach(opt => {
        if (opt.value === dbName || opt.value === svgName) {
            dropdown.value = opt.value;
        }
    });

    // Fetch films
    fetchFilmsByProvince(dbName, svgName);
}

// ══════════════════════════════════════════
// FETCH FILMS BY PROVINCE
// ══════════════════════════════════════════
async function fetchFilmsByProvince(provinceName, displayName) {
    const section   = document.getElementById('results-section');
    const heading   = document.getElementById('results-heading');
    const skeleton  = document.getElementById('films-skeleton');
    const grid      = document.getElementById('films-grid');
    const emptyEl   = document.getElementById('films-empty');
    const errorEl   = document.getElementById('films-error');
    const countWrap = document.getElementById('results-count-wrap');
    const countEl   = document.getElementById('results-count');

    // Show section & skeleton
    section.classList.remove('hidden');
    skeleton.classList.remove('hidden');
    grid.classList.add('hidden');
    emptyEl.classList.add('hidden');
    errorEl.classList.add('hidden');
    countWrap.classList.add('hidden');
    heading.textContent = displayName;

    // Scroll to results
    setTimeout(() => section.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);

    try {
        const params = new URLSearchParams({ province: provinceName, per_page: 30, sort: 'rating' });
        const res    = await fetch(`/api/films/explore?${params}`);
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();

        skeleton.classList.add('hidden');

        if (!data.data || data.data.length === 0) {
            document.getElementById('empty-msg').textContent =
                `Belum ada film dari ${displayName} yang terdaftar. Nantikan karya sineas lokal berikutnya!`;
            emptyEl.classList.remove('hidden');
            return;
        }

        // Update count
        countEl.textContent  = `${data.total} film ditemukan`;
        countWrap.classList.remove('hidden');

        // Render grid
        grid.innerHTML = data.data.map(film => {
            const poster    = film.poster_url || `https://placehold.co/300x450/1a1a1a/333333?text=${encodeURIComponent(film.title)}`;
            const detailUrl = `/film/${film.slug || film.id}`;
            const rating    = film.rating ? Number(film.rating).toFixed(1) : '–';
            const genres    = film.genres ? film.genres.slice(0, 2).join(', ') : '';
            const stars     = renderStars(film.rating);

            return `
            <div class="map-film-card select-none" onclick="window.location.href='${detailUrl}'">
                <div class="poster-wrap relative rounded-xl bg-[#1a1a1a]" style="aspect-ratio:2/3;">
                    <img src="${poster}"
                         alt="${film.title}"
                         class="w-full h-full object-cover rounded-xl"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/300x450/1a1a1a/333333?text=${encodeURIComponent(film.title)}'">
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-t from-black/80 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-200 flex flex-col justify-end p-3">
                        <div class="flex items-center gap-1 mb-1">${stars}</div>
                        <p class="text-[10px] text-gray-300 truncate">${genres}</p>
                    </div>
                    <div class="absolute top-2 right-2 bg-black/70 backdrop-blur-sm px-1.5 py-0.5 rounded-full flex items-center gap-0.5">
                        <i class="ti ti-star-filled" style="color:#f5c518;font-size:9px;"></i>
                        <span class="text-[10px] text-white font-bold">${rating}</span>
                    </div>
                </div>
                <p class="film-title mt-2 text-[13px] font-medium text-white leading-tight line-clamp-1">${film.title}</p>
                <p class="text-[11px] text-gray-500 mt-0.5">${film.year ?? ''}</p>
            </div>`;
        }).join('');

        grid.classList.remove('hidden');

    } catch (e) {
        console.error('Films fetch error:', e);
        skeleton.classList.add('hidden');
        errorEl.classList.remove('hidden');
        document.getElementById('retry-btn').onclick = () => fetchFilmsByProvince(provinceName, displayName);
    }
}

// ══════════════════════════════════════════
// STAR RENDERER
// ══════════════════════════════════════════
function renderStars(rating) {
    const r     = Number(rating) || 0;
    const full  = Math.floor(r);
    const half  = r - full >= 0.5 ? 1 : 0;
    const empty = 5 - full - half;
    let h = '';
    for (let i = 0; i < full;  i++) h += `<i class="ti ti-star-filled" style="color:#f5c518;font-size:11px"></i>`;
    if (half)                         h += `<i class="ti ti-star-half-filled" style="color:#f5c518;font-size:11px"></i>`;
    for (let i = 0; i < empty; i++) h += `<i class="ti ti-star" style="color:#555;font-size:11px"></i>`;
    return h;
}

// ══════════════════════════════════════════
// CLEAR FILTER
// ══════════════════════════════════════════
function clearFilter() {
    selectedProvince = null;

    document.querySelectorAll('#map-zoom-wrapper svg path.map-selected').forEach(p => p.classList.remove('map-selected'));

    document.getElementById('active-filter').classList.add('hidden');
    document.getElementById('active-filter').classList.remove('flex');
    document.getElementById('reset-btn').classList.add('hidden');
    document.getElementById('reset-btn').classList.remove('flex');
    document.getElementById('province-dropdown').value = '';
    document.getElementById('results-section').classList.add('hidden');
}

// ══════════════════════════════════════════
// DROPDOWN HANDLER
// ══════════════════════════════════════════
document.getElementById('province-dropdown').addEventListener('change', function () {
    const val = this.value;
    if (!val) { clearFilter(); return; }
    // Find SVG path with matching name
    const path = document.querySelector(`#map-zoom-wrapper svg path[name="${val}"]`);
    if (path) {
        selectProvince(val, val, path);
    } else {
        // Province exists in DB but maybe different name in SVG — still fetch
        selectProvince(val, val, null);
    }
});

// ══════════════════════════════════════════
// ZOOM CONTROLS
// ══════════════════════════════════════════
const zoomWrapper = document.getElementById('map-zoom-wrapper');

function applyZoom() {
    zoomWrapper.style.transform = `scale(${zoomLevel})`;
}

function zoomIn()    { zoomLevel = Math.min(zoomLevel + 0.3, 3);   applyZoom(); }
function zoomOut()   { zoomLevel = Math.max(zoomLevel - 0.3, 0.5); applyZoom(); }
function zoomReset() { zoomLevel = 1; applyZoom(); }

// Mouse wheel zoom
document.getElementById('map-container').addEventListener('wheel', (e) => {
    e.preventDefault();
    if (e.deltaY < 0) zoomIn();
    else              zoomOut();
}, { passive: false });

// ══════════════════════════════════════════
// BOOTSTRAP
// ══════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    initMap();
    loadProvinceFilmStatus();
});
</script>
@endpush
