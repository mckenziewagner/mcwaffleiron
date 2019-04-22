<div
  id="{{ $id ?? '' }}"
  class="swiper-carousel relative w-full h-full {{ $className ?? '' }}"
  data-loop="{{ $loop ?? false }}"
  data-slides-per-view="{{ $slides_per_view ?? 1 }}"
>
  <div class="swiper-wrapper">
    {!! $slot !!}
  </div>
  @if ($pagination)
    <div class="swiper-pagination"></div>
  @else
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  @endif
</div>
