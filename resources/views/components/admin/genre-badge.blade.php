@props(['genre'])

@php
$map = [
    'Drama'   => 'bg-blue-500/10 text-blue-400',
    'Horor'   => 'bg-red-500/10 text-red-400',
    'Aksi'    => 'bg-[rgba(245,197,24,0.12)] text-[#f5c518]',
    'Romansa' => 'bg-purple-500/10 text-purple-300',
    'Komedi'  => 'bg-green-500/10 text-green-400',
    'Thriller'=> 'bg-orange-500/10 text-orange-400',
    'Animasi' => 'bg-cyan-500/10 text-cyan-400',
    'Dokumenter' => 'bg-gray-500/10 text-gray-400',
];
$class = $map[$genre] ?? 'bg-white/5 text-gray-400';
@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium tracking-wide {{ $class }}">
    {{ $genre }}
</span>
