@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl">
    <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Pengaturan berhasil disimpan!');">
        @csrf
        <div class="space-y-6">

            <!-- Card: General Settings -->
            <div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden shadow-lg">
                <div class="px-6 py-4 border-b border-white/[0.07] bg-surface-2 flex items-center gap-3">
                    <i class="ti ti-adjustments text-yellow-primary text-xl"></i>
                    <div>
                        <h2 class="text-sm font-semibold text-white">Pengaturan Umum</h2>
                        <p class="text-[11px] text-gray-500">Konfigurasi dasar platform Frame Lokal.</p>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Nama Situs</label>
                            <input type="text" value="Frame Lokal" 
                                   class="w-full bg-surface-2 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Email Kontak</label>
                            <input type="email" value="admin@framelokal.com" 
                                   class="w-full bg-surface-2 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Deskripsi Meta</label>
                        <textarea rows="3" 
                                  class="w-full bg-surface-2 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-primary resize-none">Platform katalog, ulasan, dan pemetaan lokasi syuting film lokal Indonesia.</textarea>
                    </div>
                </div>
            </div>

            <!-- Card: Moderation Settings -->
            <div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden shadow-lg">
                <div class="px-6 py-4 border-b border-white/[0.07] bg-surface-2 flex items-center gap-3">
                    <i class="ti ti-messages text-yellow-primary text-xl"></i>
                    <div>
                        <h2 class="text-sm font-semibold text-white">Komunitas & Moderasi</h2>
                        <p class="text-[11px] text-gray-500">Atur ulasan, rating, dan interaksi pengguna.</p>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-3 bg-surface-2 rounded-xl border border-white/[0.03]">
                        <div>
                            <p class="text-xs font-semibold text-white">Moderasi Ulasan Baru</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">Ulasan dari penonton harus disetujui admin sebelum tampil publik.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-9 h-5 bg-surface-3 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-300 after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-yellow-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-surface-2 rounded-xl border border-white/[0.03]">
                        <div>
                            <p class="text-xs font-semibold text-white">Izinkan Komentar Pengunjung Anonim</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">Memungkinkan pengunjung tanpa login untuk mengisi kolom komentar.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-9 h-5 bg-surface-3 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-300 after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-yellow-primary"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Card: Maintenance Mode -->
            <div class="bg-surface border border-white/[0.07] rounded-xl overflow-hidden shadow-lg">
                <div class="px-6 py-4 border-b border-white/[0.07] bg-surface-2 flex items-center gap-3">
                    <i class="ti ti-tool text-yellow-primary text-xl"></i>
                    <div>
                        <h2 class="text-sm font-semibold text-white">Pemeliharaan & Sistem</h2>
                        <p class="text-[11px] text-gray-500">Kendali server dan mode pemeliharaan platform.</p>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-3 bg-surface-2 rounded-xl border border-white/[0.03]">
                        <div>
                            <p class="text-xs font-semibold text-white">Mode Pemeliharaan (Maintenance Mode)</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">Kunci akses frontend publik untuk keperluan pembaharuan server.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-9 h-5 bg-surface-3 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-300 after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-yellow-primary"></div>
                        </label>
                    </div>
                    <div class="pt-2 flex gap-3">
                        <button type="button" onclick="alert('Cache sistem dibersihkan!');"
                                class="flex items-center gap-2 px-4 py-2 border border-white/10 hover:border-yellow-primary/40 hover:text-yellow-primary transition-all text-xs font-medium rounded-xl">
                            <i class="ti ti-trash"></i> Bersihkan Cache
                        </button>
                        <button type="button" onclick="alert('Backup database dibuat!');"
                                class="flex items-center gap-2 px-4 py-2 border border-white/10 hover:border-yellow-primary/40 hover:text-yellow-primary transition-all text-xs font-medium rounded-xl">
                            <i class="ti ti-database"></i> Backup Database
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-5 py-2.5 rounded-xl border border-white/10 hover:bg-white/5 transition-colors text-xs font-bold text-gray-300">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-yellow-primary hover:bg-yellow-dim text-black transition-colors text-xs font-bold shadow-md shadow-yellow-primary/10">
                    Simpan Pengaturan
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
