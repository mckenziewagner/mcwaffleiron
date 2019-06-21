@php
  $content = isset($content) ? $content : [[
    'text'  => get_sub_field('text'),
    'image' => get_sub_field('image'),
    'style' => get_sub_field('style'),
  ]];
@endphp
<section class="text-content flex flex-col w-full container-sm">
  @foreach ($content as $item)
    @php($flip = $item['style']['flip'])
    <div class="content w-full flex md:flex-row flex-col md:my-5">
      <div
        class="text order-0 font-serif leading-loose md:p{{ $flip ? 'l' : 'r' }}-10 {{ $flip ? 'order-1' : 'order-0' }}"
        style="color: {{ $item['style']['text_color'] }};"
      >
        {!! $item['text'] !!}
      </div>
      @if ($item['image'])
        <div class="image md:my-1 mt-5 mb-4">
          <img class="{{ $flip ? 'order-0' : 'order-1' }}" src="{{ $item['image']['url'] }}" />
        </div>
      @endif
    </div>          
  @endforeach
</section>
