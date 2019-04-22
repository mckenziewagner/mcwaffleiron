<section
  class="page-header bg-center bg-no-repeat bg-cover w-full h-{{ $size ?: 'sm' }} {{ $overlay ?: 'grayscale' }} bg-white md:mb-20" 
  style="background-image: url({{ $url ?: 'not found' }}); background-color: {{ $overlay ?: 'transparent' }};"
>
  <div class="flex flex-col justify-center items-center w-full h-full">
    @if (isset($subtitle))
      <h3 class="uppercase font-sans text-3xl text-white tracking-wide m-0 text-center">{{ $subtitle }}</h3>
    @endif
    @if (isset($title))
      <h1 class="uppercase font-sans text-6xl text-white tracking-wide m-0 text-center">{{ $title }}</h1>
    @endif
  </div>
</section>
