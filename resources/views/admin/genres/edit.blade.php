@extends('layouts.admin')

@section('title', 'Edit Genre')
@section('page-title', 'Edit Genre')

@section('content')

{{-- BREADCRUMB --}}
<div class="flex items-center gap-2 text-[13px] text-gray-500 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#f5c518] transition-colors">Dashboard</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <a href="{{ route('admin.genres.index') }}" class="hover:text-[#f5c518] transition-colors">Genre</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <span class="text-gray-300">Edit Genre</span>
</div>

<div class="max-w-xl">
    <form method="POST" action="{{ route('admin.genres.update', $genre) }}">
        @csrf
        @method('PUT')

        <div class="bg-surface border border-white/[0.07] rounded-xl p-5 mb-5">
            <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Nama Genre <span class="text-red-400">*</span></label>
            <input type="text" name="name" value="{{ old('name', $genre->name) }}"
                   placeholder="Contoh: Action, Drama..."
                   class="w-full bg-surface-2 border @error('name') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[14px] text-gray-100 placeholder-gray-500 outline-none focus:border-[#c9a014] transition-colors font-sans">
            @error('name')
                <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-[#f5c518] hover:bg-[#c9a014] text-black font-medium px-6 py-2.5 rounded-lg text-[14px] transition-colors flex items-center gap-2">
                <i class="ti ti-device-floppy text-base"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.genres.index') }}"
               class="border border-white/[0.07] hover:border-white/20 text-gray-400 hover:text-gray-200 px-6 py-2.5 rounded-lg text-[14px] transition-colors flex items-center gap-2">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
