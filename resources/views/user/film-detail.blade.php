@extends('layouts.user')

@section('title', 'Detail Film')

@section('content')

{{-- ════════════════════════════════════════
     PAGE LOADING
════════════════════════════════════════ --}}
<div id="page-loading" class="flex flex-col items-center justify-center min-h-screen bg-[#0a0a0a]">
    <div class="relative w-16 h-16 mb-5">
        <div class="absolute inset-0 rounded-full border-4 border-white/5"></div>
        <div class="absolute inset-0 rounded-full border-4 border-t-[#f5c518] border-r-transparent border-b-transparent border-l-transparent animate-spin"></div>
        <div class="absolute inset-3 rounded-full bg-[#f5c518]/10 flex items-center justify-center">
            <i class="ti ti-movie text-[#f5c518] text-lg"></i>
        </div>
    </div>
    <p class="text-gray-400 text-sm font-medium">Memuat informasi film...</p>
</div>

{{-- ════════════════════════════════════════
     PAGE ERROR
════════════════════════════════════════ --}}
<div id="page-error" class="hidden flex flex-col items-center justify-center min-h-screen bg-[#0a0a0a] text-center px-6">
    <div class="w-20 h-20 rounded-2xl bg-[#111] border border-white/10 flex items-center justify-center mb-6">
        <i class="ti ti-movie-off text-4xl text-gray-600"></i>
    </div>
    <h2 class="font-display text-3xl text-white tracking-wide mb-2">Film Tidak Ditemukan</h2>
    <p class="text-gray-400 text-sm mb-7 max-w-xs">Film yang Anda cari mungkin telah dihapus atau URL tidak valid.</p>
    <a href="{{ route('explore') }}" class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#f5c518] text-black font-semibold hover:bg-[#c9a014] transition-colors shadow-lg shadow-[#f5c518]/20">
        <i class="ti ti-compass"></i> Kembali Eksplorasi
    </a>
</div>

{{-- ════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════ --}}
<div id="page-content" class="hidden">

    {{-- ─────────────────────────────────────
         HERO SECTION
    ───────────────────────────────────── --}}
    <section id="hero-section" class="relative w-full overflow-hidden bg-[#0a0a0a] pt-16">

        {{-- Backdrop --}}
        <div id="film-backdrop" class="absolute inset-0 bg-cover bg-center scale-110 blur-2xl opacity-25 transition-opacity duration-700"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-[#0a0a0a]/70 to-[#0a0a0a]/30"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#0a0a0a]/90 via-[#0a0a0a]/40 to-transparent"></div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8 py-14">

            <div class="flex flex-col lg:flex-row gap-10 lg:gap-14 items-start mb-8">
                {{-- ── Poster Column ── --}}
                <div class="w-full lg:w-72 xl:w-80 flex-shrink-0 flex flex-col gap-5">
                    {{-- Poster --}}
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-black/60 ring-1 ring-white/10 aspect-[2/3]">
                        <img id="film-poster" src="" alt="Poster Film"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>
                </div>

                {{-- ── Info Column ── --}}
                <div class="flex-1 min-w-0 pt-0 lg:pt-3">
                    {{-- Genre tags --}}
                    <div id="film-genres" class="flex flex-wrap gap-2 mb-4"></div>

                    {{-- Title --}}
                    <h1 id="film-title" class="font-display text-5xl sm:text-6xl lg:text-7xl text-white tracking-wide leading-none mb-4"></h1>

                    {{-- Meta row --}}
                    <div class="flex flex-wrap items-center gap-3 mb-7">
                        <span id="film-year" class="flex items-center gap-1.5 text-sm text-gray-300 bg-white/5 px-3 py-1 rounded-lg border border-white/10">
                            <i class="ti ti-calendar-event text-gray-500 text-sm"></i>
                        </span>
                        <span id="film-location" class="flex items-center gap-1.5 text-sm text-gray-300 bg-white/5 px-3 py-1 rounded-lg border border-white/10">
                            <i class="ti ti-map-pin text-gray-500 text-sm"></i>
                        </span>
                        <div class="flex items-center gap-2 bg-[#f5c518]/10 border border-[#f5c518]/20 px-3 py-1 rounded-lg">
                            <i class="ti ti-star-filled text-[#f5c518] text-sm"></i>
                            <span id="film-avg-rating" class="text-sm font-bold text-[#f5c518]">–</span>
                        </div>
                    </div>

                    {{-- Synopsis --}}
                    <div class="mb-8">
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 mb-3">Sinopsis</h3>
                        <p id="film-synopsis" class="text-gray-300 text-base leading-relaxed max-w-2xl"></p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-3">
                        <a id="trailer-btn" target="_blank" class="hidden flex items-center gap-2.5 bg-[#f5c518] hover:bg-[#c9a014] text-black font-bold px-7 py-3 rounded-xl transition-all duration-200 shadow-lg shadow-[#f5c518]/25 hover:shadow-[#f5c518]/40 text-sm">
                            <i class="ti ti-device-tv text-base"></i> Putar Trailer
                        </a>
                        <button id="share-btn" class="flex items-center gap-2.5 bg-white/8 hover:bg-white/15 text-white font-semibold px-6 py-3 rounded-xl border border-white/10 hover:border-white/20 transition-all duration-200 text-sm">
                            <i class="ti ti-share-2 text-base"></i> Bagikan
                        </button>
                    </div>
                </div>
            </div>

            {{-- ══ HORIZONTAL RATING WIDGET ══ --}}
            <div class="bg-[#111] rounded-2xl border border-white/10 overflow-hidden shadow-xl">
                {{-- Header --}}
                <div class="px-5 py-3 border-b border-white/[0.07]">
                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">Penilaian & Ulasan Penonton</p>
                </div>

                <div class="p-5 grid grid-cols-1 md:grid-cols-4 gap-6 items-stretch divide-y md:divide-y-0 md:divide-x divide-white/[0.07]">
                    
                    {{-- Col 1: Score Display --}}
                    <div class="flex flex-col justify-center items-center text-center pb-4 md:pb-0">
                        <div class="relative w-16 h-16 mb-2">
                            <svg class="w-16 h-16 -rotate-90" viewBox="0 0 56 56">
                                <circle cx="28" cy="28" r="24" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="4"/>
                                <circle id="rating-ring" cx="28" cy="28" r="24" fill="none" stroke="#f5c518" stroke-width="4"
                                        stroke-linecap="round" stroke-dasharray="150.8" stroke-dashoffset="150.8"
                                        style="transition: stroke-dashoffset 0.8s ease"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span id="rating-ring-text" class="text-sm font-bold text-[#f5c518]">0.0</span>
                            </div>
                        </div>
                        <div id="rating-stars-display" class="flex gap-0.5 mb-1 justify-center"></div>
                        <p id="rating-total-text" class="text-[11px] text-gray-400">0 penilaian</p>
                    </div>

                    {{-- Col 2: Percentage Bars --}}
                    <div class="flex flex-col justify-center px-0 md:px-5 py-4 md:py-0">
                        <div id="rating-bars" class="space-y-1.5">
                            {{-- filled by JS --}}
                        </div>
                    </div>

                    {{-- Col 3: User Input --}}
                    <div class="flex flex-col justify-center items-center text-center relative px-0 md:px-5 py-4 md:py-0">
                        <div id="rating-submit-overlay" class="hidden absolute inset-0 bg-[#111]/85 backdrop-blur-sm flex items-center justify-center z-10">
                            <div class="w-5 h-5 border-2 border-t-[#f5c518] border-white/10 rounded-full animate-spin"></div>
                        </div>
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-widest mb-3">Berikan Nilai</p>
                        @auth
                            <div id="star-input" class="flex items-center gap-1.5 flex-row-reverse justify-center star-input-group">
                                @for ($s = 5; $s >= 1; $s--)
                                    <input type="radio" id="rate{{ $s }}" name="user_rating" value="{{ $s }}" class="sr-only" onchange="submitRating({{ $s }})">
                                    <label for="rate{{ $s }}" class="cursor-pointer text-gray-600 hover:text-[#f5c518] transition-colors text-3xl">
                                        <i class="ti ti-star-filled"></i>
                                    </label>
                                @endfor
                            </div>
                            <div id="rating-saved-msg" class="hidden mt-2 flex items-center gap-1.5 text-xs text-green-400 justify-center">
                                <i class="ti ti-check"></i> Rating disimpan!
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-[#f5c518] text-xs font-semibold hover:bg-[#f5c518]/10 transition-colors w-full max-w-[180px]">
                                <i class="ti ti-login"></i> Masuk untuk menilai
                            </a>
                        @endauth
                    </div>

                    {{-- Col 4: Scrollable Raters List --}}
                    <div class="flex flex-col justify-between pl-0 md:pl-5 pt-4 md:pt-0">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Pemberi Rating</p>
                            <span id="raters-count-badge" class="text-[10px] text-gray-600"></span>
                        </div>
                        <div id="raters-list-container" class="h-28 overflow-y-auto pr-1" style="scrollbar-width: thin; scrollbar-color: #333 transparent;">
                            <div id="raters-list-loading" class="h-full flex items-center justify-center">
                                <div class="w-5 h-5 border-2 border-t-[#f5c518] border-white/10 rounded-full animate-spin"></div>
                            </div>
                            <div id="raters-list-empty" class="hidden h-full flex flex-col items-center justify-center text-center">
                                <i class="ti ti-star-off text-lg text-gray-700 mb-1"></i>
                                <p class="text-[10px] text-gray-600">Belum ada rating</p>
                            </div>
                            <div id="raters-list" class="hidden space-y-0.5">
                                {{-- Filled by JS --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- ─────────────────────────────────────
         COMMENTS & DISCUSSION
    ───────────────────────────────────── --}}
    <section class="bg-[#0a0a0a] pb-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="py-8 flex items-center justify-between border-b border-white/[0.07] mb-8">
                <h2 class="font-display text-3xl tracking-wide text-white">Ulasan & Diskusi</h2>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 rounded-lg border border-white/5">
                    <i class="ti ti-messages text-[#f5c518]"></i>
                    <span id="comment-count-badge" class="text-sm font-semibold text-gray-300">0</span>
                    <span class="text-sm text-gray-500">komentar</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-10">

                {{-- ── LEFT: Comments ── --}}
                <div>

                    {{-- Comment Form --}}
                    @auth
                    <div class="mb-8 bg-[#111] rounded-2xl border border-white/[0.08] overflow-hidden shadow-xl">
                        <div class="px-5 py-4 border-b border-white/[0.06] flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#f5c518] text-black flex items-center justify-center text-sm font-bold flex-shrink-0 uppercase">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <span class="text-sm font-semibold text-white">{{ auth()->user()->name }}</span>
                        </div>
                        <form id="comment-form" onsubmit="submitComment(event)">
                            <div class="relative">
                                <textarea id="main-comment" rows="4"
                                    class="w-full bg-transparent text-white text-sm p-5 focus:outline-none resize-none placeholder-gray-600 leading-relaxed"
                                    placeholder="Bagikan pandangan Anda tentang film ini... (tidak ada batasan kata)"></textarea>
                                <div id="comment-submit-overlay" class="hidden absolute inset-0 bg-[#111]/80 backdrop-blur-sm flex items-center justify-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-7 h-7 border-2 border-t-[#f5c518] border-white/10 rounded-full animate-spin"></div>
                                        <span class="text-xs text-gray-400">Menyimpan...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-5 py-3 border-t border-white/[0.06] flex items-center justify-between">
                                <span id="comment-char-count" class="text-xs text-gray-600">0 karakter</span>
                                <button type="submit"
                                    class="flex items-center gap-2 px-5 py-2 rounded-xl bg-[#f5c518] hover:bg-[#c9a014] text-black text-sm font-bold transition-colors shadow-md shadow-[#f5c518]/20">
                                    Kirim <i class="ti ti-send text-sm"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="mb-8 bg-[#111] rounded-2xl border border-white/[0.08] p-7 flex flex-col sm:flex-row items-center gap-5">
                        <div class="w-14 h-14 rounded-full bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                            <i class="ti ti-user-circle text-3xl text-gray-600"></i>
                        </div>
                        <div class="text-center sm:text-left flex-1">
                            <h3 class="font-semibold text-white mb-1">Bergabung dalam diskusi</h3>
                            <p class="text-sm text-gray-400">Masuk ke akun Anda untuk menulis komentar dan membalas pengguna lain.</p>
                        </div>
                        <a href="{{ route('login') }}"
                           class="whitespace-nowrap flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#f5c518] text-black text-sm font-bold hover:bg-[#c9a014] transition-colors shadow-lg shadow-[#f5c518]/20">
                            <i class="ti ti-login"></i> Masuk Sekarang
                        </a>
                    </div>
                    @endauth

                    {{-- Loading --}}
                    <div id="comments-loading" class="py-12 flex flex-col items-center gap-3">
                        <div class="w-8 h-8 border-2 border-t-[#f5c518] border-white/10 rounded-full animate-spin"></div>
                        <p class="text-xs text-gray-600">Memuat komentar...</p>
                    </div>

                    {{-- Empty --}}
                    <div id="comments-empty" class="hidden py-16 text-center rounded-2xl border border-dashed border-white/[0.08]">
                        <div class="w-16 h-16 rounded-2xl bg-[#111] border border-white/5 flex items-center justify-center mx-auto mb-4">
                            <i class="ti ti-messages-off text-2xl text-gray-700"></i>
                        </div>
                        <h3 class="text-gray-300 font-semibold mb-1">Belum Ada Komentar</h3>
                        <p class="text-gray-600 text-sm max-w-xs mx-auto">Jadilah yang pertama memulai diskusi tentang film ini!</p>
                    </div>

                    {{-- Comments List --}}
                    <div id="comments-list" class="space-y-6"></div>

                </div>

                {{-- ── RIGHT: Sidebar ── --}}
                <div class="space-y-5">

                    {{-- Film Stats --}}
                    <div class="bg-[#111] rounded-2xl border border-white/[0.08] p-5">
                        <h3 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-500 mb-4">Statistik Film</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400 flex items-center gap-2">
                                    <i class="ti ti-star-filled text-[#f5c518] text-base"></i> Rata-rata Rating
                                </span>
                                <span id="sidebar-avg" class="text-sm font-bold text-white">–</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400 flex items-center gap-2">
                                    <i class="ti ti-users text-gray-500 text-base"></i> Total Pemberi Rating
                                </span>
                                <span id="sidebar-raters" class="text-sm font-bold text-white">0</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400 flex items-center gap-2">
                                    <i class="ti ti-messages text-gray-500 text-base"></i> Total Komentar
                                </span>
                                <span id="sidebar-comments" class="text-sm font-bold text-white">0</span>
                            </div>
                        </div>
                    </div>

                    {{-- Community Rules --}}
                    <div class="bg-[#111] rounded-2xl border border-white/[0.08] p-5 sticky top-24">
                        <h3 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-500 mb-4">Aturan Komunitas</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2.5 text-sm text-gray-400">
                                <i class="ti ti-check-circle text-[#f5c518] mt-0.5 flex-shrink-0"></i>
                                Gunakan bahasa sopan dan saling menghargai.
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-gray-400">
                                <i class="ti ti-check-circle text-[#f5c518] mt-0.5 flex-shrink-0"></i>
                                Hindari spoiler tanpa peringatan terlebih dahulu.
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-gray-400">
                                <i class="ti ti-check-circle text-[#f5c518] mt-0.5 flex-shrink-0"></i>
                                Dilarang menyebarkan tautan ilegal.
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-gray-400">
                                <i class="ti ti-check-circle text-[#f5c518] mt-0.5 flex-shrink-0"></i>
                                Komentar tidak relevan atau spam akan dihapus.
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </section>

</div>

@endsection

@push('styles')
<style>
/* ── Star input reverse CSS trick ─────────────────── */
.star-input-group label:hover,
.star-input-group label:hover ~ label,
.star-input-group input[type="radio"]:checked ~ label {
    color: #f5c518;
}

/* ── Reply thread visual line ──────────────────────── */
.comment-thread-line {
    position: absolute;
    left: 18px;
    top: 44px;
    bottom: 12px;
    width: 2px;
    background: linear-gradient(to bottom, rgba(245,197,24,0.15), rgba(255,255,255,0.03));
    border-radius: 1px;
}

/* ── Raters scrollbar ──────────────────────────────── */
#raters-list-container::-webkit-scrollbar { width: 3px; }
#raters-list-container::-webkit-scrollbar-track { background: transparent; }
#raters-list-container::-webkit-scrollbar-thumb { background: #2a2a2a; border-radius: 2px; }

/* ── Comment textarea auto-grow ───────────────────── */
#main-comment { min-height: 100px; }

/* ── Gradient fade on hero bottom ─────────────────── */
#hero-section::after {
    content: '';
    display: block;
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 120px;
    background: linear-gradient(to top, #0a0a0a, transparent);
    pointer-events: none;
}
</style>
@endpush

@push('scripts')
<script>
// ═══════════════════════════════════════════════════════
// CONSTANTS & STATE
// ═══════════════════════════════════════════════════════
const IDENTIFIER  = "{{ $identifier }}";
const IS_AUTH     = @json(auth()->check());
let   FILM_ID     = null;
let   raterData   = [];   // cached raters for percentage calc

const CSRF = () => document.querySelector('meta[name="csrf-token"]').content;
const $    = (id) => document.getElementById(id);

// ═══════════════════════════════════════════════════════
// HELPERS
// ═══════════════════════════════════════════════════════

/** Render star icons from a numeric rating */
function starsHTML(rating, size = 'text-xs') {
    const r = parseFloat(rating) || 0;
    const full  = Math.floor(r);
    const half  = r - full >= 0.5 ? 1 : 0;
    const empty = 5 - full - half;
    let h = '';
    for (let i = 0; i < full;  i++) h += `<i class="ti ti-star-filled ${size} text-[#f5c518]"></i>`;
    if (half)                        h += `<i class="ti ti-star-half-filled ${size} text-[#f5c518]"></i>`;
    for (let i = 0; i < empty; i++) h += `<i class="ti ti-star ${size} text-gray-700"></i>`;
    return h;
}

/** Avatar initials circle */
function avatarHTML(name, sizeClass = 'w-10 h-10 text-sm') {
    const initials = name.trim().substring(0, 2).toUpperCase();
    const colors   = ['bg-violet-600','bg-blue-600','bg-teal-600','bg-rose-600','bg-amber-600','bg-pink-600'];
    const color    = colors[name.charCodeAt(0) % colors.length];
    return `<div class="${sizeClass} rounded-full ${color} flex items-center justify-center text-white font-bold flex-shrink-0 uppercase shadow">${initials}</div>`;
}

/** Update the rating circular ring gauge */
function updateRatingRing(avg, total) {
    const pct = Math.min((avg / 5) * 100, 100);
    const circumference = 150.8;
    const offset = circumference - (pct / 100) * circumference;
    $('rating-ring').style.strokeDashoffset = offset;
    $('rating-ring-text').textContent = avg ? Number(avg).toFixed(1) : '–';
    $('rating-stars-display').innerHTML = avg ? starsHTML(avg, 'text-sm') : '<span class="text-xs text-gray-600">Belum ada</span>';
    $('rating-total-text').textContent  = `${total} penilaian`;
    // Sidebar
    $('sidebar-avg').textContent    = avg ? Number(avg).toFixed(1) : '–';
    $('sidebar-raters').textContent = total;
    // Hero avg
    $('film-avg-rating').textContent = avg ? Number(avg).toFixed(1) : '–';
}

/** Render the % distribution bars (5★ → 1★) */
function renderRatingBars(raters) {
    const total = raters.length;
    const counts = {5:0, 4:0, 3:0, 2:0, 1:0};
    raters.forEach(r => { if (counts[r.rating] !== undefined) counts[r.rating]++; });

    let html = '';
    for (let star = 5; star >= 1; star--) {
        const pct = total > 0 ? Math.round((counts[star] / total) * 100) : 0;
        html += `
        <div class="flex items-center gap-2">
            <span class="text-[10px] text-gray-500 w-3 text-right">${star}</span>
            <i class="ti ti-star-filled text-[9px] text-[#f5c518] flex-shrink-0"></i>
            <div class="flex-1 h-1.5 bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-[#f5c518] rounded-full transition-all duration-700" style="width: ${pct}%"></div>
            </div>
            <span class="text-[10px] text-gray-600 w-7 text-right">${pct}%</span>
        </div>`;
    }
    $('rating-bars').innerHTML = html;
}

/** Render a single rater row */
function raterRowHTML(r) {
    return `
    <div class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg hover:bg-white/5 transition-colors">
        ${avatarHTML(r.name, 'w-6 h-6 text-[10px]')}
        <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-gray-200 truncate">${r.name}</p>
        </div>
        <div class="flex items-center gap-0.5 text-[#f5c518] flex-shrink-0">
            ${Array.from({length: r.rating}, () => '<i class="ti ti-star-filled text-[9px]"></i>').join('')}
        </div>
    </div>`;
}

// ═══════════════════════════════════════════════════════
// FETCH: Film Details
// ═══════════════════════════════════════════════════════
async function fetchFilmDetails() {
    try {
        const res = await fetch(`/api/films/${IDENTIFIER}`);
        if (!res.ok) throw new Error('not_found');
        const film = await res.json();

        FILM_ID = film.id;

        // Backdrop & poster
        const poster = film.poster_url || `https://placehold.co/400x600/1a1a1a/333?text=${encodeURIComponent(film.title)}`;
        $('film-poster').src = poster;
        $('film-backdrop').style.backgroundImage = `url('${poster}')`;

        // Text fields
        $('film-title').textContent    = film.title;
        $('film-synopsis').textContent = film.synopsis || 'Sinopsis belum tersedia.';
        $('film-year').innerHTML     = `<i class="ti ti-calendar-event text-gray-500 text-sm"></i> ${film.year || '–'}`;
        $('film-location').innerHTML = `<i class="ti ti-map-pin text-gray-500 text-sm"></i> ${film.location || 'Indonesia'}`;

        // Trailer
        const trailerBtn = $('trailer-btn');
        if (film.trailer_url) {
            trailerBtn.href = film.trailer_url;
            trailerBtn.classList.remove('hidden');
        } else {
            trailerBtn.classList.add('hidden');
        }

        // Genres
        $('film-genres').innerHTML = (film.genres || [])
            .map(g => `<span class="px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-[11px] font-bold text-gray-300 uppercase tracking-wider hover:bg-[#f5c518]/10 hover:border-[#f5c518]/20 hover:text-[#f5c518] transition-colors cursor-default">${g}</span>`)
            .join('');

        // Update page title
        document.title = `${film.title} — Frame Lokal`;

        // Show content
        $('page-loading').classList.add('hidden');
        $('page-content').classList.remove('hidden');

        // Run subsequent fetches
        await fetchRatersData();
        fetchRatingStatus();
        fetchComments();

    } catch (e) {
        $('page-loading').classList.add('hidden');
        $('page-error').classList.remove('hidden');
    }
}

// ═══════════════════════════════════════════════════════
// FETCH: Raters (includes avg calc + bars + list)
// ═══════════════════════════════════════════════════════
async function fetchRatersData() {
    if (!FILM_ID) return;
    try {
        const res  = await fetch(`/api/films/${FILM_ID}/raters`);
        const data = await res.json();

        raterData = data.raters || [];
        const total = raterData.length;
        const avg   = total > 0 ? (raterData.reduce((s, r) => s + r.rating, 0) / total) : 0;

        updateRatingRing(avg, total);
        renderRatingBars(raterData);

        // Raters count badge
        $('raters-count-badge').textContent = total ? `${total} orang` : '';

        // Show raters list
        $('raters-list-loading').classList.add('hidden');
        if (total === 0) {
            $('raters-list-empty').classList.remove('hidden');
        } else {
            $('raters-list').innerHTML = raterData.map(raterRowHTML).join('');
            $('raters-list').classList.remove('hidden');
        }

    } catch (e) {
        $('raters-list-loading').classList.add('hidden');
    }
}

// ═══════════════════════════════════════════════════════
// FETCH: User's current rating
// ═══════════════════════════════════════════════════════
async function fetchRatingStatus() {
    if (!FILM_ID || !IS_AUTH) return;
    try {
        const res  = await fetch(`/api/films/${FILM_ID}/rating-status`);
        const data = await res.json();
        if (data.rating) {
            const radio = document.getElementById(`rate${data.rating}`);
            if (radio) radio.checked = true;
        }
    } catch(e) {}
}

// ═══════════════════════════════════════════════════════
// FETCH: Comments
// ═══════════════════════════════════════════════════════
async function fetchComments() {
    if (!FILM_ID) return;

    $('comments-loading').classList.remove('hidden');
    $('comments-empty').classList.add('hidden');

    try {
        const res  = await fetch(`/api/films/${FILM_ID}/comments`);
        const data = await res.json();

        $('comments-loading').classList.add('hidden');

        const count = data.total || 0;
        $('comment-count-badge').textContent = count;
        $('sidebar-comments').textContent    = count;

        if (count === 0) {
            $('comments-empty').classList.remove('hidden');
        } else {
            $('comments-list').innerHTML = data.comments.map(commentCardHTML).join('');
        }

    } catch(e) {
        $('comments-loading').classList.add('hidden');
    }
}

// ═══════════════════════════════════════════════════════
// TEMPLATES: Comment & Reply Cards
// ═══════════════════════════════════════════════════════
function replyCardHTML(reply) {
    const mine      = reply.is_mine;
    const mineBadge = mine ? '<span class="ml-1.5 text-[9px] font-bold bg-[#f5c518]/15 text-[#f5c518] px-1.5 py-0.5 rounded uppercase tracking-wider">Anda</span>' : '';
    const delBtn    = mine ? `<button onclick="deleteReply(${reply.id})" class="text-gray-600 hover:text-red-400 transition-colors p-0.5 flex-shrink-0" title="Hapus"><i class="ti ti-trash text-sm"></i></button>` : '';

    return `
    <div id="reply-${reply.id}" class="flex gap-3 items-start">
        ${avatarHTML(reply.user.name, 'w-7 h-7 text-xs')}
        <div class="flex-1 min-w-0 bg-[#1a1a1a] rounded-xl border border-white/5 p-3">
            <div class="flex items-start justify-between gap-2 mb-1.5">
                <div>
                    <span class="text-xs font-semibold text-white">${reply.user.name}</span>${mineBadge}
                    <p class="text-[10px] text-gray-600 mt-0.5">${reply.created_at_formatted}</p>
                </div>
                ${delBtn}
            </div>
            <p class="text-sm text-gray-300 leading-relaxed whitespace-pre-wrap">${escapeHTML(reply.reply)}</p>
        </div>
    </div>`;
}

function commentCardHTML(comment) {
    const mine      = comment.is_mine;
    const mineBadge = mine ? '<span class="ml-1.5 text-[10px] font-bold bg-[#f5c518]/15 text-[#f5c518] px-2 py-0.5 rounded uppercase tracking-wider">Ulasan Anda</span>' : '';
    const delBtn    = mine ? `<button onclick="deleteComment(${comment.id})" class="text-gray-600 hover:text-red-400 transition-colors p-1 flex-shrink-0" title="Hapus"><i class="ti ti-trash"></i></button>` : '';
    const ratingBadge = comment.rating
        ? `<span class="flex items-center gap-0.5 bg-[#f5c518]/10 border border-[#f5c518]/20 text-[#f5c518] px-1.5 py-0.5 rounded text-[10px] font-bold">${starsHTML(comment.rating,'text-[9px]')} ${comment.rating}</span>`
        : '';

    const repliesHTML  = (comment.replies || []).map(replyCardHTML).join('');
    const hasReplies   = comment.replies && comment.replies.length > 0;
    const threadLine   = hasReplies ? '<div class="comment-thread-line"></div>' : '';

    const replyForm = IS_AUTH ? `
        <div id="reply-wrap-${comment.id}" class="hidden mt-3 ml-1">
            <form onsubmit="submitReply(event, ${comment.id})" class="flex gap-2 items-start">
                <textarea rows="2" class="flex-1 rounded-xl bg-[#1a1a1a] text-white text-sm border border-white/10 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#f5c518] transition-colors resize-none placeholder-gray-600" placeholder="Tulis balasan Anda..."></textarea>
                <div class="flex flex-col gap-1.5">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#f5c518] hover:bg-[#c9a014] text-black text-xs font-bold transition-colors">Kirim</button>
                    <button type="button" onclick="toggleReplyForm(${comment.id})" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-medium transition-colors border border-white/5">Batal</button>
                </div>
            </form>
        </div>` : '';

    return `
    <div id="comment-${comment.id}" class="relative">
        ${threadLine}
        <div class="flex gap-4 items-start relative z-10">
            ${avatarHTML(comment.user.name)}
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <div>
                        <div class="flex flex-wrap items-center gap-1.5 mb-0.5">
                            <h4 class="text-sm font-semibold text-white">${comment.user.name}</h4>
                            ${mineBadge}
                            ${ratingBadge}
                        </div>
                        <p class="text-[11px] text-gray-500">${comment.created_at_formatted}</p>
                    </div>
                    ${delBtn}
                </div>
                <div class="bg-[#111]/80 border border-white/[0.06] rounded-xl p-4 mb-2">
                    <p class="text-sm text-gray-200 leading-relaxed whitespace-pre-wrap">${escapeHTML(comment.comment)}</p>
                </div>
                <button onclick="toggleReplyForm(${comment.id})"
                    class="flex items-center gap-1.5 text-xs text-gray-500 hover:text-[#f5c518] transition-colors font-medium mt-1">
                    <i class="ti ti-arrow-back-up text-sm"></i> Balas
                </button>
                ${replyForm}
            </div>
        </div>

        ${hasReplies ? `<div class="mt-4 ml-14 space-y-3 relative z-10">${repliesHTML}</div>` : `<div id="replies-for-${comment.id}" class="ml-14 mt-3 space-y-3"></div>`}
    </div>`;
}

/** Escape HTML to prevent XSS */
function escapeHTML(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str || ''));
    return d.innerHTML;
}

// ═══════════════════════════════════════════════════════
// ACTIONS
// ═══════════════════════════════════════════════════════

/** Toggle reply form visibility */
function toggleReplyForm(commentId) {
    if (!IS_AUTH) { window.location.href = '/login'; return; }
    const wrap = $(`reply-wrap-${commentId}`);
    if (!wrap) return;
    wrap.classList.toggle('hidden');
    if (!wrap.classList.contains('hidden')) {
        wrap.querySelector('textarea')?.focus();
    }
}

/** Submit a star rating (auto-save on click) */
async function submitRating(value) {
    if (!FILM_ID) return;
    $('rating-submit-overlay').classList.remove('hidden');

    try {
        const res = await fetch(`/api/films/${FILM_ID}/ratings`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ rating: value })
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message);

        // Refresh raters data for live recalc
        await fetchRatersData();

        const msg = $('rating-saved-msg');
        msg.classList.remove('hidden');
        setTimeout(() => msg.classList.add('hidden'), 3000);

    } catch (e) {
        alert(e.message || 'Gagal menyimpan rating');
    } finally {
        $('rating-submit-overlay').classList.add('hidden');
    }
}

/** Submit a new top-level comment */
async function submitComment(e) {
    e.preventDefault();
    if (!FILM_ID) return;

    const textarea = $('main-comment');
    const text     = textarea.value.trim();
    if (!text) { textarea.focus(); return; }

    $('comment-submit-overlay').classList.remove('hidden');

    try {
        const res = await fetch(`/api/films/${FILM_ID}/comments`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ comment: text })
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message);

        // ── AUTO-UPDATE: prepend new comment without full reload ──
        textarea.value = '';
        $('comment-char-count').textContent = '0 karakter';
        $('comments-empty').classList.add('hidden');

        const newCard = document.createElement('div');
        newCard.innerHTML = commentCardHTML(data.comment);
        const cardEl = newCard.firstElementChild;
        cardEl.classList.add('animate-in');

        const list = $('comments-list');
        list.insertBefore(cardEl, list.firstChild);

        // Update count
        const cur = parseInt($('comment-count-badge').textContent) || 0;
        $('comment-count-badge').textContent = cur + 1;
        $('sidebar-comments').textContent    = cur + 1;

    } catch (e) {
        alert(e.message || 'Gagal mengirim komentar');
    } finally {
        $('comment-submit-overlay').classList.add('hidden');
    }
}

/** Delete a comment (user's own) */
async function deleteComment(reviewId) {
    if (!confirm('Hapus komentar ini beserta seluruh balasannya?')) return;
    try {
        const res = await fetch(`/api/comments/${reviewId}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
        });
        if (!res.ok) throw new Error('Gagal menghapus');
        const el = $(`comment-${reviewId}`);
        if (el) {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.3s';
            setTimeout(() => el.remove(), 300);
        }
        const cur = parseInt($('comment-count-badge').textContent) || 1;
        $('comment-count-badge').textContent = cur - 1;
        $('sidebar-comments').textContent    = cur - 1;
        if (cur - 1 === 0) $('comments-empty').classList.remove('hidden');
    } catch(e) { alert(e.message); }
}

/** Submit a reply to a comment */
async function submitReply(e, commentId) {
    e.preventDefault();
    const form     = e.target;
    const textarea = form.querySelector('textarea');
    const text     = textarea.value.trim();
    if (!text) { textarea.focus(); return; }

    const btn = form.querySelector('button[type="submit"]');
    btn.innerHTML = '<i class="ti ti-loader animate-spin text-sm"></i>';
    btn.disabled  = true;

    try {
        const res = await fetch(`/api/comments/${commentId}/replies`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ reply: text })
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message);

        // ── AUTO-UPDATE: append reply without full reload ──
        textarea.value = '';

        // Hide reply form
        const wrap = $(`reply-wrap-${commentId}`);
        if (wrap) wrap.classList.add('hidden');

        // Inject reply into DOM
        let replyContainer = document.querySelector(`#comment-${commentId} > div:last-child`);
        // Try the existing replies container created during render
        const existingContainer = $(`replies-for-${commentId}`);
        if (existingContainer) {
            replyContainer = existingContainer;
            // remove hidden thread wrapper placeholder if needed
        }

        if (replyContainer) {
            const newReply = document.createElement('div');
            newReply.innerHTML = replyCardHTML(data.reply);
            replyContainer.appendChild(newReply.firstElementChild);

            // Add thread line if this is the first reply
            const parentComment = $(`comment-${commentId}`);
            if (parentComment && !parentComment.querySelector('.comment-thread-line')) {
                const line = document.createElement('div');
                line.className = 'comment-thread-line';
                parentComment.insertBefore(line, parentComment.firstChild);
            }
        }

    } catch(e) {
        alert(e.message || 'Gagal mengirim balasan');
        btn.innerHTML = 'Kirim';
        btn.disabled  = false;
    }
}

/** Delete a reply */
async function deleteReply(replyId) {
    if (!confirm('Hapus balasan ini?')) return;
    try {
        const res = await fetch(`/api/replies/${replyId}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
        });
        if (!res.ok) throw new Error('Gagal menghapus');
        const el = $(`reply-${replyId}`);
        if (el) { el.style.opacity='0'; el.style.transition='opacity 0.3s'; setTimeout(() => el.remove(), 300); }
    } catch(e) { alert(e.message); }
}

// ═══════════════════════════════════════════════════════
// SHARE
// ═══════════════════════════════════════════════════════
$('share-btn')?.addEventListener('click', async () => {
    const title = $('film-title')?.textContent || 'Film';
    if (navigator.share) {
        await navigator.share({ title, url: window.location.href });
    } else {
        await navigator.clipboard.writeText(window.location.href);
        const btn = $('share-btn');
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="ti ti-check text-base"></i> Link Disalin!';
        setTimeout(() => btn.innerHTML = orig, 2000);
    }
});

// ═══════════════════════════════════════════════════════
// Character counter for textarea
// ═══════════════════════════════════════════════════════
$('main-comment')?.addEventListener('input', function() {
    const len = this.value.length;
    $('comment-char-count').textContent = `${len.toLocaleString('id')} karakter`;
});

// ═══════════════════════════════════════════════════════
// INIT
// ═══════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', fetchFilmDetails);
</script>
@endpush
