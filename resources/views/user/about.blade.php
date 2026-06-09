@extends('layouts.user')

@section('title', 'Tentang Kami')

@section('content')

<!-- ═══════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════ -->
<section class="relative min-h-[40vh] flex items-center justify-center overflow-hidden bg-[#0a0a0a] pt-24">
    <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
        <span class="text-[10px] font-semibold uppercase tracking-[0.2em] px-2.5 py-1 rounded-full bg-[#f5c518]/15 text-[#f5c518] border border-[#f5c518]/20">
            Tentang Kami
        </span>
        <h1 class="font-display text-4xl sm:text-6xl tracking-wider text-white mt-5 mb-5 leading-none">
            FRAME LOKAL
        </h1>
        <p class="text-gray-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
            Platform apresiasi film lokal Indonesia yang menghubungkan penonton dengan sinema terbaik nusantara dan memetakan lokasi-lokasi syuting bernilai budaya tinggi.
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     STATISTICS SECTION
     ═══════════════════════════════════════════ -->
<section class="max-w-4xl mx-auto px-6 mb-12">
    <div class="grid grid-cols-3 gap-4 p-6 rounded-xl bg-[#111] border border-white/[0.05] shadow-lg">
        <div class="text-center">
            <div class="font-display text-3xl sm:text-4xl text-[#f5c518] mb-0.5">{{ $totalFilms }}</div>
            <div class="text-[10px] uppercase tracking-wider text-gray-500 font-medium">Katalog Film</div>
        </div>
        <div class="text-center border-l border-white/[0.05]">
            <div class="font-display text-3xl sm:text-4xl text-white mb-0.5">{{ $totalProvinces }}</div>
            <div class="text-[10px] uppercase tracking-wider text-gray-500 font-medium">Provinsi</div>
        </div>
        <div class="text-center border-l border-white/[0.05]">
            <div class="font-display text-3xl sm:text-4xl text-white mb-0.5">{{ $totalReviews }}</div>
            <div class="text-[10px] uppercase tracking-wider text-gray-500 font-medium">Ulasan</div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     VISI & MISI
     ═══════════════════════════════════════════ -->
<section class="max-w-4xl mx-auto px-6 pb-20">
    <div class="space-y-6">
        <!-- Visi -->
        <div class="p-6 sm:p-8 rounded-xl bg-[#111] border border-white/[0.05]">
            <div class="flex items-center gap-3 mb-3">
                <i class="ti ti-eye text-xl text-[#f5c518]"></i>
                <h3 class="font-display text-2xl text-white tracking-wide">Visi</h3>
            </div>
            <p class="text-gray-400 text-sm leading-relaxed">
                Menjadi wadah apresiasi utama bagi komunitas pecinta film lokal Indonesia untuk mengeksplorasi, mendiskusikan, dan menghidupkan karya sinematik nusantara.
            </p>
        </div>

        <!-- Misi -->
        <div class="p-6 sm:p-8 rounded-xl bg-[#111] border border-white/[0.05]">
            <div class="flex items-center gap-3 mb-3">
                <i class="ti ti-target text-xl text-[#f5c518]"></i>
                <h3 class="font-display text-2xl text-white tracking-wide">Misi</h3>
            </div>
            <ul class="space-y-3.5 text-gray-400 text-sm">
                <li class="flex items-start gap-2.5">
                    <i class="ti ti-circle-check-filled text-[#f5c518] mt-0.5 flex-shrink-0 text-base"></i>
                    <span>Mengenalkan dan mengarsipkan film lokal berkualitas dari seluruh penjuru daerah.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="ti ti-circle-check-filled text-[#f5c518] mt-0.5 flex-shrink-0 text-base"></i>
                    <span>Memetakan lokasi syuting bersejarah dan wisata perfilman nusantara secara interaktif.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="ti ti-circle-check-filled text-[#f5c518] mt-0.5 flex-shrink-0 text-base"></i>
                    <span>Membangun ruang ulasan dan kritik film yang terbuka serta interaktif untuk para sinefil.</span>
                </li>
            </ul>
        </div>
    </div>
</section>

@endsection
