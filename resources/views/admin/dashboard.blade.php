@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-4 gap-4 mb-6">

    {{-- Total Film --}}
    <div class="relative bg-surface border border-white/[0.07] rounded-xl p-5 overflow-hidden hover:border-[#c9a014] transition-colors cursor-default group">
        <div class="absolute -top-5 -right-5 w-20 h-20 rounded-full bg-[rgba(245,197,24,0.08)] group-hover:bg-[rgba(245,197,24,0.14)] transition-colors"></div>
        <div class="w-10 h-10 bg-[rgba(245,197,24,0.10)] rounded-lg flex items-center justify-center mb-4">
            <i class="ti ti-movie text-[#f5c518] text-lg"></i>
        </div>
        <p class="text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-1.5">Total Film</p>
        <p class="font-display text-[34px] tracking-wide leading-none">{{ $totalFilms }}</p>
        <p class="text-[11px] text-green-400 mt-2 flex items-center gap-1">
            <i class="ti ti-trending-up text-xs"></i> +{{ $filmsThisMonth }} bulan ini
        </p>
    </div>

    {{-- Provinsi --}}
    <div class="relative bg-surface border border-white/[0.07] rounded-xl p-5 overflow-hidden hover:border-[#c9a014] transition-colors cursor-default group">
        <div class="absolute -top-5 -right-5 w-20 h-20 rounded-full bg-[rgba(245,197,24,0.08)] group-hover:bg-[rgba(245,197,24,0.14)] transition-colors"></div>
        <div class="w-10 h-10 bg-[rgba(245,197,24,0.10)] rounded-lg flex items-center justify-center mb-4">
            <i class="ti ti-map-2 text-[#f5c518] text-lg"></i>
        </div>
        <p class="text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-1.5">Provinsi</p>
        <p class="font-display text-[34px] tracking-wide leading-none">{{ $totalProvinces }}</p>
        <p class="text-[11px] text-green-400 mt-2 flex items-center gap-1">
            <i class="ti ti-check text-xs"></i> Semua tercover
        </p>
    </div>

    {{-- Pengguna --}}
    <div class="relative bg-surface border border-white/[0.07] rounded-xl p-5 overflow-hidden hover:border-[#c9a014] transition-colors cursor-default group">
        <div class="absolute -top-5 -right-5 w-20 h-20 rounded-full bg-[rgba(245,197,24,0.08)] group-hover:bg-[rgba(245,197,24,0.14)] transition-colors"></div>
        <div class="w-10 h-10 bg-[rgba(245,197,24,0.10)] rounded-lg flex items-center justify-center mb-4">
            <i class="ti ti-users text-[#f5c518] text-lg"></i>
        </div>
        <p class="text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-1.5">Pengguna</p>
        <p class="font-display text-[34px] tracking-wide leading-none">{{ $totalUsers >= 1000 ? number_format($totalUsers/1000, 1).'K' : $totalUsers }}</p>
        <p class="text-[11px] text-green-400 mt-2 flex items-center gap-1">
            <i class="ti ti-trending-up text-xs"></i> +{{ $usersThisWeek }} minggu ini
        </p>
    </div>

    {{-- Ulasan --}}
    <div class="relative bg-surface border border-white/[0.07] rounded-xl p-5 overflow-hidden hover:border-[#c9a014] transition-colors cursor-default group">
        <div class="absolute -top-5 -right-5 w-20 h-20 rounded-full bg-[rgba(245,197,24,0.08)] group-hover:bg-[rgba(245,197,24,0.14)] transition-colors"></div>
        <div class="w-10 h-10 bg-[rgba(245,197,24,0.10)] rounded-lg flex items-center justify-center mb-4">
            <i class="ti ti-message text-[#f5c518] text-lg"></i>
        </div>
        <p class="text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-1.5">Ulasan</p>
        <p class="font-display text-[34px] tracking-wide leading-none">{{ $totalReviews }}</p>
        <p class="text-[11px] text-green-400 mt-2 flex items-center gap-1">
            <i class="ti ti-trending-up text-xs"></i> +{{ $reviewsToday }} hari ini
        </p>
    </div>
</div>

{{-- MAIN CONTENT ROW --}}
<div class="grid grid-cols-[1fr_360px] gap-4">

    {{-- FILM TABLE --}}
    <div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-white/[0.07]">
            <span class="w-2 h-2 rounded-full bg-[#f5c518]"></span>
            <span class="text-[13px] font-medium flex-1">Film Terbaru</span>
            <a href="{{ route('admin.films.create') }}"
               class="bg-[rgba(245,197,24,0.10)] border border-[#c9a014] text-[#f5c518] text-[11px] font-medium px-3 py-1.5 rounded-lg hover:bg-[rgba(245,197,24,0.20)] transition-colors tracking-wide">
                + Tambah Film
            </a>
        </div>

        <table class="w-full">
            <thead>
                <tr class="border-b border-white/[0.07]">
                    <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-2.5 font-normal">Film</th>
                    <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-2.5 font-normal">Genre</th>
                    <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-2.5 font-normal">Tahun</th>
                    <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-2.5 font-normal">Rating</th>
                    <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-2.5 font-normal">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentFilms as $film)
                <tr class="border-b border-white/[0.04] hover:bg-surface-2 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-11 rounded bg-surface-3 border border-white/[0.07] flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($film->poster)
                                    <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->title }}" class="w-full h-full object-cover">
                                @else
                                    <i class="ti ti-photo text-gray-600 text-xs"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-[13px] font-medium">{{ $film->title }}</p>
                                <p class="text-[11px] text-gray-500 flex items-center gap-1">
                                    <i class="ti ti-map-pin text-[10px]"></i>
                                    {{ $film->regency->name ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex flex-wrap gap-1">
                            @foreach($film->genres->take(2) as $genre)
                                <x-admin.genre-badge :genre="$genre->name" />
                            @endforeach
                        </div>
                    </td>
                    <td class="px-5 py-3 text-[13px] text-gray-300">{{ $film->year }}</td>
                    <td class="px-5 py-3">
                        <x-admin.star-rating :rating="$film->rating" />
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex gap-1.5">
                            <a href="{{ route('admin.films.edit', $film) }}"
                               class="w-7 h-7 rounded-md border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-[#f5c518] hover:border-[#c9a014] transition-colors">
                                <i class="ti ti-edit text-[13px]"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.films.destroy', $film) }}"
                                  onsubmit="return confirm('Hapus film {{ addslashes($film->title) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-7 h-7 rounded-md border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-red-400 hover:border-red-500/40 transition-colors">
                                    <i class="ti ti-trash text-[13px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-gray-500 text-sm">
                        <i class="ti ti-movie-off text-2xl block mb-2"></i> Belum ada film
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($recentFilms->count() > 0)
        <div class="px-5 py-3 border-t border-white/[0.07] flex justify-end">
            <a href="{{ route('admin.films.index') }}" class="text-[12px] text-[#f5c518] hover:underline flex items-center gap-1">
                Lihat semua film <i class="ti ti-arrow-right text-xs"></i>
            </a>
        </div>
        @endif
    </div>

    {{-- RIGHT PANELS --}}
    <div class="flex flex-col gap-4">

        {{-- FILM PER PROVINSI --}}
        <div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-white/[0.07]">
                <span class="w-2 h-2 rounded-full bg-[#f5c518]"></span>
                <span class="text-[13px] font-medium">Film per Provinsi</span>
            </div>
            <div class="p-5">
                @foreach($filmsByProvince as $province)
                <div class="flex items-center gap-3 mb-3 last:mb-0">
                    <span class="text-[12px] text-gray-400 w-24 truncate flex-shrink-0">{{ $province->name }}</span>
                    <div class="flex-1 h-1.5 bg-surface-3 rounded-full">
                        <div class="h-1.5 rounded-full bg-[#f5c518]"
                             style="width: {{ $filmsByProvince->max('films_count') > 0 ? ($province->films_count / $filmsByProvince->max('films_count') * 100) : 0 }}%">
                        </div>
                    </div>
                    <span class="text-[12px] text-gray-200 w-6 text-right flex-shrink-0">{{ $province->films_count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- AKTIVITAS TERBARU --}}
        <div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-white/[0.07]">
                <span class="w-2 h-2 rounded-full bg-[#f5c518]"></span>
                <span class="text-[13px] font-medium">Aktivitas Terbaru</span>
            </div>
            <div class="px-5">
                @forelse($recentReviews as $review)
                <div class="flex gap-3 py-3 border-b border-white/[0.04] last:border-0">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-message text-blue-400 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[12.5px] text-gray-200 leading-relaxed">
                            <span class="text-[#f5c518] font-medium">{{ $review->user->name }}</span>
                            memberi ulasan pada
                            <span class="text-[#f5c518] font-medium">{{ $review->film->title }}</span>
                        </p>
                        <span class="text-[11px] text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-gray-500 text-sm">Belum ada aktivitas</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
