@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')

@section('content')

{{-- BREADCRUMB --}}
<div class="flex items-center gap-2 text-[13px] text-gray-500 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#f5c518] transition-colors">Dashboard</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <a href="{{ route('admin.users.index') }}" class="hover:text-[#f5c518] transition-colors">Kelola Pengguna</a>
    <i class="ti ti-chevron-right text-xs"></i>
    <span class="text-gray-300">Tambah Pengguna</span>
</div>

<div class="max-w-xl">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="bg-surface border border-white/[0.07] rounded-xl p-5 mb-5 space-y-4">
            
            {{-- Name --}}
            <div>
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Nama <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Masukkan nama pengguna"
                       class="w-full bg-surface-2 border @error('name') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[14px] text-gray-100 placeholder-gray-500 outline-none focus:border-[#c9a014] transition-colors font-sans" required>
                @error('name')
                    <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Email <span class="text-red-400">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Masukkan email pengguna"
                       class="w-full bg-surface-2 border @error('email') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[14px] text-gray-100 placeholder-gray-500 outline-none focus:border-[#c9a014] transition-colors font-sans" required>
                @error('email')
                    <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Password <span class="text-red-400">*</span></label>
                <input type="password" name="password"
                       placeholder="Minimal 8 karakter"
                       class="w-full bg-surface-2 border @error('password') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[14px] text-gray-100 placeholder-gray-500 outline-none focus:border-[#c9a014] transition-colors font-sans" required>
                @error('password')
                    <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Konfirmasi Password <span class="text-red-400">*</span></label>
                <input type="password" name="password_confirmation"
                       placeholder="Ulangi password"
                       class="w-full bg-surface-2 border border-white/[0.07] rounded-lg px-4 py-2.5 text-[14px] text-gray-100 placeholder-gray-500 outline-none focus:border-[#c9a014] transition-colors font-sans" required>
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-[11px] text-gray-500 uppercase tracking-[1.5px] mb-2">Role <span class="text-red-400">*</span></label>
                <select name="role" class="w-full bg-surface-2 border @error('role') border-red-500/60 @else border-white/[0.07] @enderror rounded-lg px-4 py-2.5 text-[14px] text-gray-100 outline-none focus:border-[#c9a014] transition-colors font-sans cursor-pointer" required>
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1.5 text-[12px] text-red-400 flex items-center gap-1"><i class="ti ti-alert-circle text-xs"></i> {{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-[#f5c518] hover:bg-[#c9a014] text-black font-medium px-6 py-2.5 rounded-lg text-[14px] transition-colors flex items-center gap-2">
                <i class="ti ti-device-floppy text-base"></i> Simpan Pengguna
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="border border-white/[0.07] hover:border-white/20 text-gray-400 hover:text-gray-200 px-6 py-2.5 rounded-lg text-[14px] transition-colors flex items-center gap-2">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
