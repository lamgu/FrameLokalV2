@extends('layouts.admin')

@section('title', 'Notifikasi')
@section('page-title', 'Pemberitahuan Aktivitas')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Notification Header Info -->
    <div class="bg-surface border border-white/[0.07] rounded-xl p-5 flex items-center justify-between shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-yellow-pale flex items-center justify-center text-yellow-primary">
                <i class="ti ti-bell-ringing text-xl"></i>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-white">Log Aktivitas Terbaru</h2>
                <p class="text-[11px] text-gray-500">Menampilkan pembaruan sistem, ulasan baru, dan pengguna terdaftar.</p>
            </div>
        </div>
        <button onclick="alert('Semua notifikasi ditandai dibaca!');" 
                class="flex items-center gap-1.5 px-3 py-1.5 border border-white/10 hover:border-yellow-primary/40 hover:text-yellow-primary text-xs font-semibold rounded-lg transition-colors">
            <i class="ti ti-check-all"></i> Tandai Dibaca
        </button>
    </div>

    <!-- Timeline of Activity -->
    <div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden shadow-lg">
        <div class="px-6 py-4 border-b border-white/[0.07] bg-surface-2">
            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Timeline Pembaruan</p>
        </div>

        <div class="divide-y divide-white/[0.05]">
            
            {{-- Loop Reviews --}}
            @foreach($recentReviews as $review)
            <div class="p-5 flex gap-4 items-start hover:bg-white/[0.02] transition-colors">
                <div class="w-9 h-9 rounded-full bg-blue-500/10 text-blue-400 flex items-center justify-center flex-shrink-0">
                    <i class="ti ti-message text-base"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-4 mb-1">
                        <p class="text-xs text-white">
                            <span class="font-bold text-gray-200">{{ $review->user->name ?? 'Pengguna' }}</span> 
                            memberikan rating 
                            <span class="text-yellow-primary font-bold">★ {{ $review->rating }}</span> 
                            pada film 
                            <span class="font-bold text-yellow-primary">{{ $review->film->title ?? 'Film' }}</span>
                        </p>
                        <span class="text-[10px] text-gray-500 flex-shrink-0">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    @if($review->comment)
                        <p class="text-xs text-gray-400 italic bg-surface-2 border border-white/[0.05] rounded-lg p-2.5 mt-1.5 line-clamp-2">
                            "{{ $review->comment }}"
                        </p>
                    @endif
                </div>
            </div>
            @endforeach

            {{-- Loop Users --}}
            @foreach($recentUsers as $user)
            <div class="p-5 flex gap-4 items-start hover:bg-white/[0.02] transition-colors">
                <div class="w-9 h-9 rounded-full bg-green-500/10 text-green-400 flex items-center justify-center flex-shrink-0">
                    <i class="ti ti-user-plus text-base"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-4 mb-0.5">
                        <p class="text-xs text-white">
                            Pengguna Baru terdaftar: <span class="font-bold text-gray-200">{{ $user->name }}</span> ({{ $user->email }})
                        </p>
                        <span class="text-[10px] text-gray-500 flex-shrink-0">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                    <span class="inline-block text-[9px] uppercase tracking-wider bg-white/5 text-gray-400 px-2 py-0.5 rounded-full border border-white/5 font-semibold mt-1">
                        {{ $user->is_admin ? 'Admin' : 'Pengguna Biasa' }}
                    </span>
                </div>
            </div>
            @endforeach

            {{-- Loop Films --}}
            @foreach($recentFilms as $film)
            <div class="p-5 flex gap-4 items-start hover:bg-white/[0.02] transition-colors">
                <div class="w-9 h-9 rounded-full bg-yellow-pale text-yellow-primary flex items-center justify-center flex-shrink-0">
                    <i class="ti ti-movie text-base"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-4 mb-0.5">
                        <p class="text-xs text-white">
                            Film Baru ditambahkan: <span class="font-bold text-yellow-primary">{{ $film->title }}</span>
                        </p>
                        <span class="text-[10px] text-gray-500 flex-shrink-0">{{ $film->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1 flex items-center gap-2">
                        <span>Tahun: {{ $film->year ?? '–' }}</span>
                        <span>·</span>
                        <span>Lokasi: {{ $film->location ?? '–' }}</span>
                    </p>
                </div>
            </div>
            @endforeach

            @if($recentReviews->isEmpty() && $recentUsers->isEmpty() && $recentFilms->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <i class="ti ti-bell-off text-3xl block mb-2"></i>
                Belum ada notifikasi atau aktivitas baru.
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
