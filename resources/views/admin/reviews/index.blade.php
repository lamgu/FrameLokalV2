@extends('layouts.admin')

@section('title', 'Kelola Ulasan')
@section('page-title', 'Kelola Ulasan')

@section('content')

{{-- HEADER ROW --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-400 text-sm">Total <span class="text-[#f5c518] font-medium">{{ $reviews->total() }}</span> ulasan</p>
    </div>
</div>

{{-- FILTER BAR --}}
<div class="bg-surface border border-white/[0.07] rounded-xl px-5 py-4 mb-5 flex items-center gap-4">
    <div class="flex items-center gap-2 bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-2 flex-1 max-w-sm">
        <i class="ti ti-search text-gray-500 text-sm"></i>
        <input type="text" id="search-input" placeholder="Cari ulasan atau nama user..."
               class="bg-transparent border-none outline-none text-[13px] text-gray-100 placeholder-gray-500 w-full font-sans">
    </div>
</div>

{{-- TABLE --}}
<div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
    <table class="w-full" id="reviews-table">
        <thead>
            <tr class="border-b border-white/[0.07]">
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal w-12">#</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Pengguna</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Film</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Rating & Komentar</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Tanggal</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal w-24">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $index => $review)
            <tr class="review-row border-b border-white/[0.04] hover:bg-surface-2 transition-colors"
                data-search="{{ strtolower($review->user->name . ' ' . $review->comment . ' ' . $review->film->title) }}">
                <td class="px-5 py-4 text-[13px] text-gray-500 align-top">{{ $reviews->firstItem() + $index }}</td>
                <td class="px-5 py-4 align-top">
                    <p class="text-[14px] font-medium text-gray-100">{{ $review->user->name }}</p>
                    <p class="text-[12px] text-gray-500">{{ $review->user->email }}</p>
                </td>
                <td class="px-5 py-4 align-top">
                    <a href="{{ route('admin.films.show', $review->film) }}" class="text-[13px] text-[#f5c518] hover:underline">
                        {{ $review->film->title }}
                    </a>
                </td>
                <td class="px-5 py-4 align-top max-w-xs">
                    <div class="mb-2">
                        <x-admin.star-rating :rating="$review->rating" />
                    </div>
                    <p class="text-[13px] text-gray-300 leading-relaxed line-clamp-2" title="{{ $review->comment }}">
                        "{{ $review->comment }}"
                    </p>
                </td>
                <td class="px-5 py-4 text-[13px] text-gray-300 align-top">
                    {{ $review->created_at->format('d M Y, H:i') }}
                </td>
                <td class="px-5 py-4 align-top">
                    <div class="flex gap-1.5">
                        <a href="{{ route('admin.reviews.show', $review) }}"
                           title="Lihat Detail"
                           class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-blue-400 hover:border-blue-400/40 transition-colors">
                            <i class="ti ti-eye text-sm"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                              onsubmit="return confirm('Yakin ingin menghapus ulasan dari \'{{ addslashes($review->user->name) }}\'?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    title="Hapus Ulasan"
                                    class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-red-400 hover:border-red-500/40 transition-colors">
                                <i class="ti ti-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-16 text-center">
                    <i class="ti ti-message-off text-3xl text-gray-600 block mb-3"></i>
                    <p class="text-gray-500 text-sm">Belum ada ulasan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Empty search state --}}
    <div id="no-results" class="hidden px-5 py-16 text-center">
        <i class="ti ti-search-off text-3xl text-gray-600 block mb-3"></i>
        <p class="text-gray-500 text-sm">Tidak ada ulasan yang cocok dengan pencarian.</p>
    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-5">
    {{ $reviews->links() }}
</div>

@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('search-input');
    const rows        = document.querySelectorAll('.review-row');
    const noResults   = document.getElementById('no-results');

    searchInput.addEventListener('input', () => {
        const search = searchInput.value.toLowerCase();
        let visible  = 0;

        rows.forEach(row => {
            const match = row.dataset.search.includes(search);
            row.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        noResults.classList.toggle('hidden', visible > 0 || rows.length === 0);
    });
</script>
@endpush
