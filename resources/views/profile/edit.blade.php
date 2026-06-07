@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')

{{-- ════════════════════════════════════════
     TOAST NOTIFICATION
════════════════════════════════════════ --}}
<div id="toast-container" class="fixed top-20 right-5 z-[9999] flex flex-col gap-2 pointer-events-none"></div>

{{-- ════════════════════════════════════════
     PAGE HEADER
════════════════════════════════════════ --}}
<div class="relative pt-24 pb-8 px-6 lg:px-8 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-[#f5c518]/5 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto relative">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#f5c518] mb-2">Akun Saya</p>
        <h1 class="font-display text-4xl sm:text-5xl text-white tracking-wide">Profil</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola informasi akun dan lihat riwayat aktivitas Anda</p>
    </div>
</div>

{{-- ════════════════════════════════════════
     MAIN LAYOUT: 2 PANEL
════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-6 lg:px-8 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-[380px_1fr] gap-8 items-start">

        {{-- ══════════════════════════════
             LEFT PANEL — Profile & Settings
        ══════════════════════════════ --}}
        <div class="space-y-5">

            {{-- Avatar card --}}
            <div class="bg-[#111] border border-white/[0.07] rounded-2xl p-6 text-center">
                <div class="relative inline-block mb-4">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#f5c518] to-[#c9a014] flex items-center justify-center text-black text-3xl font-bold shadow-lg shadow-[#f5c518]/20">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-green-500 border-2 border-[#111] flex items-center justify-center">
                        <i class="ti ti-check text-white text-xs"></i>
                    </div>
                </div>
                <h2 class="text-white font-semibold text-lg">{{ auth()->user()->name }}</h2>
                <p class="text-gray-500 text-sm mt-0.5">{{ auth()->user()->email }}</p>
                <div class="mt-3 inline-flex items-center gap-1.5 bg-[#f5c518]/10 border border-[#f5c518]/20 px-3 py-1 rounded-full">
                    <i class="ti ti-user text-[#f5c518] text-xs"></i>
                    <span class="text-[#f5c518] text-xs font-semibold">Pengguna Aktif</span>
                </div>
            </div>

            {{-- Edit Profile Form --}}
            <div class="bg-[#111] border border-white/[0.07] rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/[0.07] flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#f5c518]/10 flex items-center justify-center">
                        <i class="ti ti-user-edit text-[#f5c518] text-sm"></i>
                    </div>
                    <span class="text-sm font-semibold text-white">Informasi Profil</span>
                </div>
                <div class="p-6">
                    @if(session('status') === 'profile-updated')
                        <script>document.addEventListener('DOMContentLoaded', () => showToast('Profil berhasil diperbarui!', 'success'));</script>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" id="profile-name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required autocomplete="name"
                                   class="w-full bg-[#1a1a1a] border border-white/[0.08] rounded-xl px-4 py-2.5 text-white text-sm
                                          focus:outline-none focus:border-[#f5c518] focus:ring-1 focus:ring-[#f5c518]/30 transition-all
                                          placeholder-gray-600">
                            @error('name')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" id="profile-email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required autocomplete="username"
                                   class="w-full bg-[#1a1a1a] border border-white/[0.08] rounded-xl px-4 py-2.5 text-white text-sm
                                          focus:outline-none focus:border-[#f5c518] focus:ring-1 focus:ring-[#f5c518]/30 transition-all
                                          placeholder-gray-600">
                            @error('email')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-[#f5c518] hover:bg-[#c9a014] text-black
                                       font-semibold text-sm py-2.5 rounded-xl transition-all duration-200 shadow-lg shadow-[#f5c518]/10
                                       hover:shadow-[#f5c518]/20">
                            <i class="ti ti-device-floppy text-base"></i>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Change Password Form --}}
            <div class="bg-[#111] border border-white/[0.07] rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/[0.07] flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                        <i class="ti ti-lock text-blue-400 text-sm"></i>
                    </div>
                    <span class="text-sm font-semibold text-white">Ubah Password</span>
                </div>
                <div class="p-6">
                    @if(session('status') === 'password-updated')
                        <script>document.addEventListener('DOMContentLoaded', () => showToast('Password berhasil diperbarui!', 'success'));</script>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Password Saat Ini</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password"
                                       autocomplete="current-password"
                                       class="w-full bg-[#1a1a1a] border border-white/[0.08] rounded-xl px-4 py-2.5 text-white text-sm
                                              focus:outline-none focus:border-[#f5c518] focus:ring-1 focus:ring-[#f5c518]/30 transition-all
                                              placeholder-gray-600 pr-10">
                                <button type="button" onclick="togglePassword('current_password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                                    <i class="ti ti-eye text-sm"></i>
                                </button>
                            </div>
                            @error('current_password', 'updatePassword')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password" id="new_password"
                                       autocomplete="new-password"
                                       class="w-full bg-[#1a1a1a] border border-white/[0.08] rounded-xl px-4 py-2.5 text-white text-sm
                                              focus:outline-none focus:border-[#f5c518] focus:ring-1 focus:ring-[#f5c518]/30 transition-all
                                              placeholder-gray-600 pr-10">
                                <button type="button" onclick="togglePassword('new_password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                                    <i class="ti ti-eye text-sm"></i>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="confirm_password"
                                       autocomplete="new-password"
                                       class="w-full bg-[#1a1a1a] border border-white/[0.08] rounded-xl px-4 py-2.5 text-white text-sm
                                              focus:outline-none focus:border-[#f5c518] focus:ring-1 focus:ring-[#f5c518]/30 transition-all
                                              placeholder-gray-600 pr-10">
                                <button type="button" onclick="togglePassword('confirm_password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                                    <i class="ti ti-eye text-sm"></i>
                                </button>
                            </div>
                            @error('password_confirmation', 'updatePassword')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white
                                       font-semibold text-sm py-2.5 rounded-xl transition-all duration-200">
                            <i class="ti ti-lock-check text-base"></i>
                            Perbarui Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- Stats mini card --}}
            <div id="stats-card" class="bg-[#111] border border-white/[0.07] rounded-2xl p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Statistik Aktivitas</p>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-[#1a1a1a] rounded-xl p-3 text-center">
                        <p id="stat-ratings" class="font-display text-3xl text-[#f5c518] tracking-wide">—</p>
                        <p class="text-xs text-gray-500 mt-1">Film Di-rating</p>
                    </div>
                    <div class="bg-[#1a1a1a] rounded-xl p-3 text-center">
                        <p id="stat-comments" class="font-display text-3xl text-blue-400 tracking-wide">—</p>
                        <p class="text-xs text-gray-500 mt-1">Ulasan Ditulis</p>
                    </div>
                </div>
            </div>

        </div>{{-- /LEFT PANEL --}}

        {{-- ══════════════════════════════
             RIGHT PANEL — Activity History
        ══════════════════════════════ --}}
        <div class="bg-[#111] border border-white/[0.07] rounded-2xl overflow-hidden">

            {{-- Tab Navigation --}}
            <div class="flex border-b border-white/[0.07]">
                <button id="tab-ratings-btn" onclick="switchTab('ratings')"
                        class="activity-tab active flex-1 flex items-center justify-center gap-2 py-4 px-5 text-sm font-semibold
                               transition-all duration-200 border-b-2 border-[#f5c518] text-[#f5c518]">
                    <i class="ti ti-star-filled text-base"></i>
                    <span>Film Di-Rating</span>
                    <span id="badge-ratings" class="hidden px-2 py-0.5 rounded-full bg-[#f5c518]/20 text-[#f5c518] text-xs font-bold"></span>
                </button>
                <button id="tab-comments-btn" onclick="switchTab('comments')"
                        class="activity-tab flex-1 flex items-center justify-center gap-2 py-4 px-5 text-sm font-semibold
                               transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-300">
                    <i class="ti ti-message text-base"></i>
                    <span>Ulasan Saya</span>
                    <span id="badge-comments" class="hidden px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-400 text-xs font-bold"></span>
                </button>
            </div>

            {{-- ── TAB: RATINGS ── --}}
            <div id="tab-ratings" class="p-6">

                {{-- Skeleton --}}
                <div id="ratings-skeleton" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                    @for ($i = 0; $i < 8; $i++)
                    <div>
                        <div class="skeleton w-full rounded-xl" style="aspect-ratio:2/3;"></div>
                        <div class="skeleton h-3 w-3/4 rounded-full mt-3"></div>
                        <div class="skeleton h-3 w-1/2 rounded-full mt-2"></div>
                    </div>
                    @endfor
                </div>

                {{-- Grid --}}
                <div id="ratings-grid" class="hidden grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4 gap-y-6"></div>

                {{-- Empty --}}
                <div id="ratings-empty" class="hidden flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-[#1a1a1a] border border-white/[0.07] flex items-center justify-center mb-4">
                        <i class="ti ti-star text-3xl text-gray-700"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-1">Belum ada rating</h3>
                    <p class="text-gray-500 text-sm max-w-xs">Mulai berikan rating pada film-film yang telah Anda tonton!</p>
                    <a href="{{ route('explore') }}"
                       class="mt-5 px-5 py-2 rounded-xl bg-[#f5c518] hover:bg-[#c9a014] text-black text-sm font-semibold transition-colors">
                        Jelajahi Film
                    </a>
                </div>

                {{-- Error --}}
                <div id="ratings-error" class="hidden flex flex-col items-center justify-center py-16 text-center">
                    <i class="ti ti-wifi-off text-4xl text-gray-700 mb-3"></i>
                    <p class="text-gray-500 text-sm mb-4">Gagal memuat data. Periksa koneksi Anda.</p>
                    <button onclick="fetchRatings()" class="px-4 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white text-sm transition-colors">
                        Coba Lagi
                    </button>
                </div>
            </div>

            {{-- ── TAB: COMMENTS ── --}}
            <div id="tab-comments" class="hidden p-6">

                {{-- Skeleton --}}
                <div id="comments-skeleton" class="space-y-3">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="bg-[#1a1a1a] rounded-xl p-4">
                        <div class="flex gap-3">
                            <div class="skeleton w-12 h-16 rounded-lg flex-shrink-0"></div>
                            <div class="flex-1 space-y-2 pt-1">
                                <div class="skeleton h-3 w-1/3 rounded-full"></div>
                                <div class="skeleton h-3 w-full rounded-full"></div>
                                <div class="skeleton h-3 w-4/5 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                {{-- List --}}
                <div id="comments-list" class="hidden space-y-3"></div>

                {{-- Empty --}}
                <div id="comments-empty" class="hidden flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-[#1a1a1a] border border-white/[0.07] flex items-center justify-center mb-4">
                        <i class="ti ti-message text-3xl text-gray-700"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-1">Belum ada ulasan</h3>
                    <p class="text-gray-500 text-sm max-w-xs">Bagikan pendapat Anda tentang film yang telah Anda tonton!</p>
                    <a href="{{ route('explore') }}"
                       class="mt-5 px-5 py-2 rounded-xl bg-[#f5c518] hover:bg-[#c9a014] text-black text-sm font-semibold transition-colors">
                        Jelajahi Film
                    </a>
                </div>

                {{-- Error --}}
                <div id="comments-error" class="hidden flex flex-col items-center justify-center py-16 text-center">
                    <i class="ti ti-wifi-off text-4xl text-gray-700 mb-3"></i>
                    <p class="text-gray-500 text-sm mb-4">Gagal memuat data. Periksa koneksi Anda.</p>
                    <button onclick="fetchComments()" class="px-4 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white text-sm transition-colors">
                        Coba Lagi
                    </button>
                </div>
            </div>

        </div>{{-- /RIGHT PANEL --}}

    </div>
</div>

@endsection

@push('styles')
<style>
/* Tab transitions */
.activity-tab { position: relative; }
.activity-tab.active { color: #f5c518; border-color: #f5c518; }
.activity-tab:not(.active) { color: #6b7280; border-color: transparent; }
#tab-comments-btn.active { color: #60a5fa; border-color: #60a5fa; }

/* Rating card hover */
.rating-card { cursor: pointer; }
.rating-card .poster-wrap { transition: transform 0.3s ease; }
.rating-card:hover .poster-wrap { transform: scale(1.03); }

/* Toast */
.toast {
    display: flex; align-items: flex-start; gap: 12px;
    background: #1a1a1a; border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px; padding: 14px 16px;
    min-width: 280px; max-width: 380px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.5);
    pointer-events: all;
    animation: toastIn 0.3s ease forwards;
}
.toast.success { border-left: 3px solid #f5c518; }
.toast.error   { border-left: 3px solid #ef4444; }
.toast.info    { border-left: 3px solid #3b82f6; }
@keyframes toastIn {
    from { opacity: 0; transform: translateX(20px); }
    to   { opacity: 1; transform: translateX(0);    }
}
@keyframes toastOut {
    from { opacity: 1; transform: translateX(0);    }
    to   { opacity: 0; transform: translateX(20px); }
}
</style>
@endpush

@push('scripts')
<script>
// ══════════════════════════════════════════════
// TOAST SYSTEM
// ══════════════════════════════════════════════
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const icons = { success: 'ti-circle-check', error: 'ti-circle-x', info: 'ti-info-circle' };
    const colors = { success: '#f5c518', error: '#ef4444', info: '#3b82f6' };

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <i class="ti ${icons[type] || icons.info} text-xl flex-shrink-0" style="color:${colors[type] || colors.info}"></i>
        <div class="flex-1">
            <p class="text-[13px] text-white font-medium leading-snug">${message}</p>
        </div>
        <button onclick="this.closest('.toast').remove()" class="text-gray-500 hover:text-white flex-shrink-0 transition-colors">
            <i class="ti ti-x text-sm"></i>
        </button>
    `;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'toastOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// ══════════════════════════════════════════════
// PASSWORD TOGGLE
// ══════════════════════════════════════════════
function togglePassword(id) {
    const input = document.getElementById(id);
    const btn = input.nextElementSibling;
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'ti ti-eye-off text-sm';
    } else {
        input.type = 'password';
        icon.className = 'ti ti-eye text-sm';
    }
}

// ══════════════════════════════════════════════
// TAB SWITCHING
// ══════════════════════════════════════════════
function switchTab(tab) {
    // Panels
    document.getElementById('tab-ratings').classList.toggle('hidden', tab !== 'ratings');
    document.getElementById('tab-comments').classList.toggle('hidden', tab !== 'comments');

    // Buttons
    const rBtn = document.getElementById('tab-ratings-btn');
    const cBtn = document.getElementById('tab-comments-btn');
    rBtn.className = 'activity-tab flex-1 flex items-center justify-center gap-2 py-4 px-5 text-sm font-semibold transition-all duration-200 border-b-2 '
        + (tab === 'ratings' ? 'border-[#f5c518] text-[#f5c518] active' : 'border-transparent text-gray-500 hover:text-gray-300');
    cBtn.className = 'activity-tab flex-1 flex items-center justify-center gap-2 py-4 px-5 text-sm font-semibold transition-all duration-200 border-b-2 '
        + (tab === 'comments' ? 'border-blue-400 text-blue-400 active' : 'border-transparent text-gray-500 hover:text-gray-300');
}

// ══════════════════════════════════════════════
// STAR RENDERER
// ══════════════════════════════════════════════
function renderStars(rating, size = '13px') {
    const r = Number(rating) || 0;
    const full  = Math.floor(r);
    const half  = r - full >= 0.5 ? 1 : 0;
    const empty = 5 - full - half;
    let h = '';
    for (let i = 0; i < full;  i++) h += `<i class="ti ti-star-filled" style="color:#f5c518;font-size:${size}"></i>`;
    if (half)                         h += `<i class="ti ti-star-half-filled" style="color:#f5c518;font-size:${size}"></i>`;
    for (let i = 0; i < empty; i++) h += `<i class="ti ti-star" style="color:#444;font-size:${size}"></i>`;
    return h;
}

// ══════════════════════════════════════════════
// FETCH: USER RATINGS
// ══════════════════════════════════════════════
async function fetchRatings() {
    const skeleton = document.getElementById('ratings-skeleton');
    const grid     = document.getElementById('ratings-grid');
    const empty    = document.getElementById('ratings-empty');
    const errEl    = document.getElementById('ratings-error');

    skeleton.classList.remove('hidden');
    grid.classList.add('hidden');
    empty.classList.add('hidden');
    errEl.classList.add('hidden');

    try {
        const res  = await fetch('/api/user/ratings');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();

        skeleton.classList.add('hidden');

        // Update stat badge
        document.getElementById('stat-ratings').textContent = data.total ?? 0;
        const badge = document.getElementById('badge-ratings');
        if (data.total > 0) {
            badge.textContent = data.total;
            badge.classList.remove('hidden');
        }

        if (!data.ratings || data.ratings.length === 0) {
            empty.classList.remove('hidden');
            return;
        }

        grid.innerHTML = data.ratings.map(item => {
            const film      = item.film;
            const poster    = film.poster_url || `https://placehold.co/300x450/1a1a1a/333333?text=${encodeURIComponent(film.title)}`;
            const detailUrl = `/film/${film.slug || film.id}`;
            const stars     = renderStars(item.rating);
            const genres    = film.genres ? film.genres.slice(0, 2).join(', ') : '';

            return `
            <div class="rating-card select-none" onclick="window.location.href='${detailUrl}'">
                <div class="relative rounded-xl overflow-hidden bg-[#1a1a1a] poster-wrap" style="aspect-ratio:2/3;">
                    <img src="${poster}" alt="${film.title}"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/300x450/1a1a1a/333333?text=${encodeURIComponent(film.title)}'">
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black to-transparent p-3">
                        <div class="flex items-center gap-1">${stars}</div>
                        <span class="text-[#f5c518] text-xs font-bold">${Number(item.rating).toFixed(1)} / 5</span>
                    </div>
                    <div class="absolute top-2 right-2 bg-[#f5c518] text-black text-[10px] font-bold px-1.5 py-0.5 rounded-md">
                        ★ ${Number(item.rating).toFixed(1)}
                    </div>
                </div>
                <p class="mt-2 text-[13px] font-medium text-white leading-tight line-clamp-1 hover:text-[#f5c518] transition-colors">${film.title}</p>
                <p class="text-[11px] text-gray-500 mt-0.5">${film.year ?? ''} ${genres ? '· ' + genres : ''}</p>
                <p class="text-[10px] text-gray-600 mt-0.5">${item.created_at ?? ''}</p>
            </div>`;
        }).join('');

        grid.classList.remove('hidden');

    } catch (e) {
        console.error('Ratings fetch error:', e);
        skeleton.classList.add('hidden');
        errEl.classList.remove('hidden');
    }
}

// ══════════════════════════════════════════════
// FETCH: USER COMMENTS
// ══════════════════════════════════════════════
async function fetchComments() {
    const skeleton = document.getElementById('comments-skeleton');
    const list     = document.getElementById('comments-list');
    const empty    = document.getElementById('comments-empty');
    const errEl    = document.getElementById('comments-error');

    skeleton.classList.remove('hidden');
    list.classList.add('hidden');
    empty.classList.add('hidden');
    errEl.classList.add('hidden');

    try {
        const res  = await fetch('/api/user/comments');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();

        skeleton.classList.add('hidden');

        // Update stat badge
        document.getElementById('stat-comments').textContent = data.total ?? 0;
        const badge = document.getElementById('badge-comments');
        if (data.total > 0) {
            badge.textContent = data.total;
            badge.classList.remove('hidden');
        }

        if (!data.comments || data.comments.length === 0) {
            empty.classList.remove('hidden');
            return;
        }

        list.innerHTML = data.comments.map(item => {
            const film      = item.film;
            const poster    = film.poster_url || `https://placehold.co/300x450/1a1a1a/333333?text=${encodeURIComponent(film.title)}`;
            const detailUrl = `/film/${film.slug || film.id}`;
            const stars     = item.rating ? renderStars(item.rating, '11px') : '';
            const ratingBadge = item.rating
                ? `<span class="flex items-center gap-0.5">${stars}<span class="text-[#f5c518] text-xs font-bold ml-1">${Number(item.rating).toFixed(1)}</span></span>`
                : `<span class="text-xs text-gray-600">Tanpa rating</span>`;

            // Truncate long comments
            const commentText = item.comment.length > 200
                ? item.comment.substring(0, 200) + '...'
                : item.comment;

            return `
            <div class="bg-[#1a1a1a] hover:bg-[#1f1f1f] border border-white/[0.05] hover:border-white/[0.10] rounded-xl p-4 transition-all duration-200">
                <div class="flex gap-3">
                    {{-- Poster mini --}}
                    <a href="${detailUrl}" class="flex-shrink-0 w-12 h-[72px] rounded-lg overflow-hidden block">
                        <img src="${poster}" alt="${film.title}"
                             class="w-full h-full object-cover hover:opacity-80 transition-opacity"
                             onerror="this.src='https://placehold.co/300x450/1a1a1a/333333?text=?'">
                    </a>
                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <a href="${detailUrl}" class="text-[13px] font-semibold text-white hover:text-[#f5c518] transition-colors line-clamp-1">
                                ${film.title}
                            </a>
                            <span class="text-[10px] text-gray-600 flex-shrink-0">${item.created_at ?? ''}</span>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                            ${ratingBadge}
                            <span class="text-gray-700 text-xs">•</span>
                            <span class="text-xs text-gray-600">${film.year ?? ''}</span>
                        </div>
                        <p class="text-[12.5px] text-gray-400 leading-relaxed line-clamp-3">${commentText}</p>
                    </div>
                </div>
                <div class="mt-3 flex justify-end">
                    <a href="${detailUrl}"
                       class="flex items-center gap-1.5 text-[11px] text-gray-500 hover:text-[#f5c518] transition-colors border border-white/[0.06] hover:border-[#f5c518]/30 px-3 py-1 rounded-lg">
                        <i class="ti ti-arrow-right text-xs"></i>
                        Lihat Film
                    </a>
                </div>
            </div>`;
        }).join('');

        list.classList.remove('hidden');

    } catch (e) {
        console.error('Comments fetch error:', e);
        skeleton.classList.add('hidden');
        errEl.classList.remove('hidden');
    }
}

// ══════════════════════════════════════════════
// BOOTSTRAP
// ══════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    fetchRatings();
    fetchComments();
});
</script>
@endpush
