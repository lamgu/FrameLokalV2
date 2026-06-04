@extends('layouts.admin')

@section('title', 'Detail Ulasan')
@section('page-title', 'Detail Ulasan')

@section('content')

{{-- BREADCRUMB --}}
<div class="flex items-center gap-2 text-[13px] text-gray-500 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#f5c518] transition-colors">Dashboard</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <a href="{{ route('admin.reviews.index') }}" class="hover:text-[#f5c518] transition-colors">Ulasan</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <span class="text-gray-300">Detail</span>
</div>

<div class="max-w-2xl bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
    {{-- Header --}}
    <div class="px-6 py-5 border-b border-white/[0.07] flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#f5c518] flex items-center justify-center text-black font-bold text-lg flex-shrink-0">
                {{ strtoupper(substr($review->user->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="text-base font-medium text-white">{{ $review->user->name }}</h3>
                <p class="text-[13px] text-gray-500">{{ $review->user->email }}</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-[12px] text-gray-500 mb-1">Diulas pada</p>
            <p class="text-[13px] text-gray-300">{{ $review->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-6">
        <div class="mb-5 p-4 bg-surface-2 border border-white/[0.07] rounded-lg flex items-center gap-4">
            <div class="w-12 h-16 bg-surface-3 rounded overflow-hidden flex-shrink-0">
                @if($review->film->poster)
                    <img src="{{ Storage::url($review->film->poster) }}" alt="{{ $review->film->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-600"><i class="ti ti-photo"></i></div>
                @endif
            </div>
            <div>
                <p class="text-[11px] text-gray-500 uppercase tracking-widest mb-1">Film</p>
                <p class="text-[15px] font-medium text-[#f5c518]">{{ $review->film->title }}</p>
            </div>
        </div>

        <div class="mb-4">
            <p class="text-[11px] text-gray-500 uppercase tracking-widest mb-2">Rating</p>
            <x-admin.star-rating :rating="$review->rating" />
        </div>

        <div>
            <p class="text-[11px] text-gray-500 uppercase tracking-widest mb-2">Komentar</p>
            <div class="text-[14px] text-gray-200 leading-relaxed bg-surface-2 p-5 rounded-lg border border-white/[0.04]">
                "{{ $review->comment }}"
            </div>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="px-6 py-4 border-t border-white/[0.07] bg-surface-2 flex items-center gap-3">
        <a href="{{ route('admin.reviews.index') }}"
           class="border border-white/[0.07] hover:border-white/20 text-gray-400 hover:text-gray-200 px-5 py-2 rounded-lg text-[13px] transition-colors flex items-center gap-2">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        
        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
              onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')" class="ml-auto">
            @csrf @method('DELETE')
            <button type="submit"
                    class="bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 px-5 py-2 rounded-lg text-[13px] transition-colors flex items-center gap-2">
                <i class="ti ti-trash"></i> Hapus Ulasan
            </button>
        </form>
    </div>
</div>

@endsection
