<section class="all-menus mt-24 mb-40">
  <div class="container">
    <div class="flex flex-row flex-wrap justify-center items-center">
      @php($j = 0)
      @foreach (get_sub_field('menu_select') as $post_id)
        @php( $image = get_field('header', $post_id)['image'] )
        @php( $url = (string)get_post($post_id)->post_name )
        <div
          id="menu-{{ $j }}"
          {{-- class="{{ $j == 3 ? 'w-1/2 items-center' : $j == 4 ? 'w-1/2 items-center' : 'w-1/3 items-center' }} py-10 flex flex-col flex-wrap justify-center" --}}
          class="{{ $j == 3 ? 'md:w-1/2 items-center' : $j == 4 ? 'md:w-1/2 items-center' : 'md:w-1/3' }} w-full py-3 flex flex-col flex-wrap justify-center {{ $j == 0 ? 'md:items-start' : '' }} {{ $j == 1 ? 'md:items-center' : '' }} {{ $j == 2 ? 'md:items-end' : ''}} items-center"
        >
          <a
            href="/menu/{{ $url }}"
            class="relative {{ ($j == 3) ? 'md:ml-40' : '' }} {{ ($j == 4) ? 'md:mr-40' : '' }} menu-link cursor-pointer border-4 border-orange border-solid w-menus h-menus rounded-full flex flex-col justify-center items-center"
          >
            <h4 class="relative font-sans tracking-wide text-grey text-xl font-light uppercase px-10 z-20">Menus</h4>
            <h2 class="relative font-sans tracking-wide text-center text-orange text-3xl font-light uppercase px-8 z-20">{{ get_the_title($post_id) }}</h2>
            <div style="background-image: url({{ $image['url'] }});" class="z-10 bg-img absolute rounded-full pin-t pin-l w-full h-full bg-cover bg-no-repeat"></div>
          </a>
        </div>
        @php
          if ($j < 4) {
            $j++;
          } else {
            $j = 0;
          }
        @endphp
      @endforeach
    </div>
  </div>
</section>
