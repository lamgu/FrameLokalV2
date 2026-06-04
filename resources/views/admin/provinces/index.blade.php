@extends('layouts.admin')

@section('title', 'Kelola Lokasi')
@section('page-title', 'Kelola Lokasi')

@section('content')

{{-- HEADER ROW --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-400 text-sm">Total <span class="text-[#f5c518] font-medium">{{ $provinces->total() }}</span> provinsi terdaftar</p>
    </div>
    <a href="{{ route('admin.provinces.create') }}"
       class="flex items-center gap-2 bg-[#f5c518] hover:bg-[#c9a014] text-black text-sm font-medium px-4 py-2.5 rounded-lg transition-colors">
        <i class="ti ti-plus text-base"></i> Tambah Provinsi
    </a>
</div>

{{-- FILTER BAR --}}
<div class="bg-surface border border-white/[0.07] rounded-xl px-5 py-4 mb-5 flex items-center gap-4">
    <div class="flex items-center gap-2 bg-surface-2 border border-white/[0.07] rounded-lg px-3 py-2 flex-1 max-w-sm">
        <i class="ti ti-search text-gray-500 text-sm"></i>
        <input type="text" id="search-input" placeholder="Cari provinsi..."
               class="bg-transparent border-none outline-none text-[13px] text-gray-100 placeholder-gray-500 w-full font-sans">
    </div>
</div>

{{-- TABLE --}}
<div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
    <table class="w-full" id="provinces-table">
        <thead>
            <tr class="border-b border-white/[0.07]">
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal w-16">#</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Nama Provinsi</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Jumlah Kab/Kota</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Dibuat Pada</th>
                <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal w-32">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($provinces as $index => $province)
            <tr class="province-row border-b border-white/[0.04] hover:bg-surface-2 transition-colors"
                data-name="{{ strtolower($province->name) }}">
                <td class="px-5 py-3 text-[13px] text-gray-500">{{ $provinces->firstItem() + $index }}</td>
                <td class="px-5 py-3">
                    <p class="text-[14px] font-medium text-gray-100">{{ $province->name }}</p>
                </td>
                <td class="px-5 py-3 text-[13px] text-gray-300">
                    {{ $province->regencies_count }} kab/kota
                </td>
                <td class="px-5 py-3 text-[13px] text-gray-300">{{ $province->created_at->format('d M Y') }}</td>
                <td class="px-5 py-3">
                    <div class="flex gap-1.5">
                        <a href="{{ route('admin.provinces.show', $province) }}"
                           title="Lihat Detail & Kab/Kota"
                           class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-blue-400 hover:border-blue-400/40 transition-colors">
                            <i class="ti ti-eye text-sm"></i>
                        </a>
                        <a href="{{ route('admin.provinces.edit', $province) }}"
                           title="Edit Provinsi"
                           class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-[#f5c518] hover:border-[#c9a014] transition-colors">
                            <i class="ti ti-edit text-sm"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.provinces.destroy', $province) }}"
                              onsubmit="return confirm('Yakin ingin menghapus provinsi \'{{ addslashes($province->name) }}\'? Semua kab/kota di dalamnya akan ikut terhapus.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    title="Hapus Provinsi"
                                    class="w-8 h-8 rounded-lg border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-red-400 hover:border-red-500/40 transition-colors">
                                <i class="ti ti-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-16 text-center">
                    <i class="ti ti-map-pin text-3xl text-gray-600 block mb-3"></i>
                    <p class="text-gray-500 text-sm">Belum ada provinsi. <a href="{{ route('admin.provinces.create') }}" class="text-[#f5c518] hover:underline">Tambah sekarang</a></p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Empty search state --}}
    <div id="no-results" class="hidden px-5 py-16 text-center">
        <i class="ti ti-search-off text-3xl text-gray-600 block mb-3"></i>
        <p class="text-gray-500 text-sm">Tidak ada provinsi yang cocok dengan pencarian.</p>
    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-5">
    {{ $provinces->links() }}
</div>

@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('search-input');
    const rows        = document.querySelectorAll('.province-row');
    const noResults   = document.getElementById('no-results');

    searchInput.addEventListener('input', () => {
        const search = searchInput.value.toLowerCase();
        let visible  = 0;

        rows.forEach(row => {
            const matchName = row.dataset.name.includes(search);
            row.classList.toggle('hidden', !matchName);
            if (matchName) visible++;
        });

        noResults.classList.toggle('hidden', visible > 0 || rows.length === 0);
    });
</script>
@endpush
