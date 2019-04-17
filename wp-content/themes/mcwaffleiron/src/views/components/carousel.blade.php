<div
  id="{{ $id ?? '' }}"
  class="carousel relative w-full h-full"
  @if (isset($data))
    @foreach ($data as $key => $value)
      @php 
        $datatype = gettype($value);
        if ($datatype === boolean || $datatype === bool) {
          if ($value) {
            $value = 'true';
          } else {
            $value = 'false';
          }
        }
      @endphp
      {{ 'data-'.$key.'='.$value }}
    @endforeach
  @endif
>
  <div class="carousel-wrapper {{ $className ?? '' }}">
    {!! $slot !!}
  </div>
  <div class="carousel-nav w-full">
    <button class="next">
      <svg class="{{ $navColor ?? 'fill-white' }}" viewBox='0 0 27 44'><path d='M0,22L22,0l2.1,2.1L4.2,22l19.9,19.9L22,44L0,22L0,22L0,22z'/></svg>
    </button>
    <button class="prev">
      <svg class="{{ $navColor ?? 'fill-white' }}" viewBox='0 0 27 44'><path d='M27,22L27,22L5,44l-2.1-2.1L22.8,22L2.9,2.1L5,0L27,22L27,22z'/></svg>
    </button>
  </div>
</div>
