@props(['rating' => 0, 'max' => 5])

@php $rating = round($rating); @endphp

<div class="flex items-center gap-0.5" title="{{ $rating }}/{{ $max }}">
    @for($i = 1; $i <= $max; $i++)
        @if($i <= $rating)
            <i class="ti ti-star-filled text-[#f5c518] text-xs"></i>
        @else
            <i class="ti ti-star text-white/10 text-xs"></i>
        @endif
    @endfor
</div>
