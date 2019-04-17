<a href="{{ $link }}" style="background-color: {{ $bg_color ?? '#fdb927' }}; border-color: {{ $shadow_color ?? '#ce66e19' }};box-shadow: 8px 8px 0 {{ $shadow_color ?? '#ce66e19' }}; color: {{ $shadow_color ?? '#ce66e19' }};" class="big-button border-3 block w-full px-3 pt-6 pb-5 text-center cursor-pointer">
  <h5 style="color: {{ $subheading_color }};" class="uppercase font-sans md:text-base text-xs my-0 tracking-huge font-normal">{{ $subheading }}</h5>
  <h2 style="color: {{ $heading_color }};" class="uppercase font-sans font-normal md:text-4xl text-xl my-0 tracking-wider">{{ $heading }}</h2>
</a>
