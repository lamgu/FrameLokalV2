@extends('layouts.admin')

@section('title', 'Detail Provinsi & Kab/Kota')
@section('page-title', 'Detail Provinsi')

@section('content')

{{-- BREADCRUMB --}}
<div class="flex items-center gap-2 text-[13px] text-gray-500 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#f5c518] transition-colors">Dashboard</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <a href="{{ route('admin.provinces.index') }}" class="hover:text-[#f5c518] transition-colors">Lokasi</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <span class="text-gray-300">{{ $province->name }}</span>
</div>

<div class="grid grid-cols-[1fr_360px] gap-5 items-start">
    
    {{-- DAFTAR KAB/KOTA --}}
    <div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-white/[0.07]">
            <i class="ti ti-map-pin text-[#f5c518] text-lg"></i>
            <span class="text-[14px] font-medium flex-1">Daftar Kabupaten / Kota</span>
            <span class="text-xs text-gray-500 bg-surface-3 px-2 py-1 rounded-md">{{ $province->regencies->count() }} total</span>
        </div>

        <table class="w-full">
            <thead>
                <tr class="border-b border-white/[0.07]">
                    <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal w-12">#</th>
                    <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal">Nama Kabupaten/Kota</th>
                    <th class="text-left text-[10px] text-gray-500 uppercase tracking-[1.5px] px-5 py-3 font-normal w-24">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($province->regencies as $index => $regency)
                <tr class="border-b border-white/[0.04] hover:bg-surface-2 transition-colors group">
                    <td class="px-5 py-3 text-[13px] text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-5 py-3">
                        {{-- Form Edit Inline (Hidden by default) --}}
                        <form method="POST" action="{{ route('admin.provinces.regencies.update', [$province, $regency]) }}" class="hidden items-center gap-2" id="edit-form-{{ $regency->id }}">
                            @csrf @method('PUT')
                            <input type="text" name="name" value="{{ $regency->name }}" required
                                   class="bg-surface-2 border border-white/[0.07] rounded px-3 py-1.5 text-[13px] text-gray-100 outline-none focus:border-[#c9a014] w-full max-w-[200px]">
                            <button type="submit" class="w-7 h-7 rounded bg-green-500/20 text-green-400 hover:bg-green-500/30 flex items-center justify-center"><i class="ti ti-check"></i></button>
                            <button type="button" onclick="toggleEdit({{ $regency->id }})" class="w-7 h-7 rounded bg-surface-3 text-gray-400 hover:text-white flex items-center justify-center"><i class="ti ti-x"></i></button>
                        </form>
                        
                        {{-- Teks Normal --}}
                        <div class="text-[14px] font-medium text-gray-100" id="text-name-{{ $regency->id }}">
                            {{ $regency->name }}
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex gap-1.5" id="actions-{{ $regency->id }}">
                            <button type="button" onclick="toggleEdit({{ $regency->id }})"
                                    class="w-7 h-7 rounded-md border border-white/[0.07] flex items-center justify-center text-gray-400 hover:text-[#f5c518] hover:border-[#c9a014] transition-colors">
                                <i class="ti ti-edit text-[13px]"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.provinces.regencies.destroy', [$province, $regency]) }}"
                                  onsubmit="return confirm('Hapus kab/kota {{ addslashes($regency->name) }}?')">
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
                    <td colspan="3" class="px-5 py-10 text-center text-gray-500 text-sm">
                        <i class="ti ti-map-pin-off text-2xl block mb-2"></i> Belum ada kab/kota untuk provinsi ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TAMBAH KAB/KOTA --}}
    <div class="bg-surface border border-white/[0.07] rounded-xl p-5 sticky top-5">
        <h3 class="text-[13px] font-medium text-[#f5c518] mb-4">Tambah Kab / Kota</h3>
        <form method="POST" action="{{ route('admin.provinces.regencies.store', $province) }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Nama Kab/Kota <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Kota Bandung..."
                       class="w-full bg-surface-2 border @error('name') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[13px] text-gray-100 placeholder-gray-500 outline-none focus:border-[#c9a014] transition-colors font-sans">
                @error('name')
                    <p class="mt-1.5 text-[11px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-[10px]"></i> {{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="w-full bg-[#f5c518] hover:bg-[#c9a014] text-black font-medium py-2.5 rounded-lg text-[13px] transition-colors">
                + Tambah Data
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function toggleEdit(id) {
        const form = document.getElementById(`edit-form-${id}`);
        const text = document.getElementById(`text-name-${id}`);
        const actions = document.getElementById(`actions-${id}`);
        
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            form.classList.add('flex');
            text.classList.add('hidden');
            actions.classList.add('hidden');
        } else {
            form.classList.add('hidden');
            form.classList.remove('flex');
            text.classList.remove('hidden');
            actions.classList.remove('hidden');
        }
    }
</script>
@endpush
