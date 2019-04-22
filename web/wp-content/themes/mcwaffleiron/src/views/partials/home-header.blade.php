@php
  $i = 1;
@endphp
<section class="home-header h-full">
  <div class="home-header-wrap relative flex flex-col w-full">
    <div class="top flex md:flex-row flex-col w-full h-full">
      <div class="slideshow h-full md:w-3/5 w-full bg-cover bg-no-repeat bg-center flex flex-col justify-end items-center" style="background-image: url({{ get_field('header_gallery')[0]['url'] }});">
        <button class="text-white hover:text-black modal-toggle bg-transparent hover:bg-white border px-5 py-2 mb-12 border-solid border-white tracking-massive font-sans uppercase text-lg font-light">View Slideshow ></button>
        @component('components.modal')
          @component('components.carousel', [
            'id' => 'main-gallery',
            'className' => 'my-40',
            'data' => [
              'loop' => true,
              'center' => true,
              'items' => 1,
            ]
          ])
            @foreach(get_field('header_gallery') as $image)
              <div class="image-modal !inline-flex justify-center items-center flex-row">
                <img src="{{ $image['url'] }}" />
              </div>
            @endforeach
          @endcomponent
        @endcomponent
      </div>
      <div class="classics-to-go h-full md:w-2/5 w-full bg-cover bg-no-repeat bg-center" style="background-image: url({{ get_field('header_images')[0]['url'] }});">
        <div class="flex flex-row justify-center items-center w-full h-full">
          <a href="#" class="md:w-64 md:h-64 w-56 h-56 m-4 flex flex-row justify-center items-center bg-green rounded-full">
            <div class="md:w-56 md:h-56 h-48 w-48 flex flex-col justify-center items-center rounded-full border-white border-2 border-solid p-5 bg-transparent">
              <h5 class="font-sans tracking-wide leading-tight font-light uppercase m-0 text-sm text-white text-center leading-none">Order Our</h5>
              <h4 class="font-sans tracking-wide m-0 text-4xl font-light uppercase text-white text-center leading-hug">Classics To-Go</h4>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="bottom flex md:flex-row flex-col w-full h-full">
      <div class="event-menus h-full md:w-2/5 w-full bg-cover bg-no-repeat bg-center" style="background-image: url({{ get_field('header_images')[1]['url'] }});">
        <div class="flex flex-row justify-center items-center w-full h-full">
          <a href="#" class="md:w-64 md:h-64 w-56 h-56 m-4 flex flex-row justify-center items-center bg-yellow rounded-full">
            <div class="md:w-56 md:h-56 w-48 h-48 flex flex-col justify-center items-center rounded-full border-white border-2 border-solid p-5 bg-transparent">
              <h5 class="font-sans tracking-wide leading-tight font-light uppercase m-0 text-sm text-white text-center leading-none">See Previous</h5>
              <h4 class="font-sans tracking-wide m-0 text-4xl font-light uppercase text-white text-center leading-hug">Event Menus</h4>
            </div>
          </a>
        </div>
      </div>
      <div class="entire-menu h-full md:w-3/5 w-full bg-orange bg-cover bg-no-repeat bg-center" style="background-image: url({{ get_field('header_images')[2]['url'] }});">
        <div class="flex justify-center items-center w-full h-full md:p-12 p-5">
          <a href="#" class="flex flex-col justify-center items-center border-2 border-solid border-white entire-menu-link">
            <h3 class="font-sans font-medium tracking-wide text-3xl text-white uppercase text-center m-0 leading-tight">View Our</h3>
            <h2 class="font-sans font-medium tracking-huge text-5xl text-white uppercase text-center m-0 leading-hug">Entire Menu</h2>
            <p class="m-0 pt-4 font-serif text-white text-center font-medium text-lg md:block hidden">
              Elit sit sint quibusdam repellendus optio. Reprehenderit ad modi non ex ut mollitia Molestias quis dicta repudiandae facilis quasi Nemo aperiam accusamus sapiente iste laboriosam? Quo eaque ea libero repellat?
            </p>
          </a>
        </div>
      </div>
    </div>
  </div>
  {{--
  <div class="grid relative">
    @foreach (get_field('gallery') as $slide)
      @if ($slide['acf_fc_layout'] === 'image')
        <div class="grid-item md:block hidden">
          <img src="{{ $slide['image']['sizes']['720'] }}" title="{{ $slide['image']['title'] }}" alt="{{ $slide['image']['alt'] }}">
        </div>
      @endif

      @if ($slide['acf_fc_layout'] === 'call_to_action')
        <div class="grid-item call-to-action-item">
          <img src="{{ $slide['image']['sizes']['720'] }}" title="{{ $slide['image']['title'] }}" alt="{{ $slide['image']['alt'] }}">
          <div style="background-color: {{ hex_to_rgba($slide['style']['overlay_color'], $slide['style']['opacity'] / 100) }});" class="overlay-{{ $i }} absolute w-full top-0 left-0">
          </div>
          <a class="call-to-action-wrap flex justify-center items-center" href="{{ $slide['page'] }}">
            <div class="call-to-action-slide-{{ $i++ }} bg-white rounded-full">
              <div class="absolute pin-t pin-l w-full h-full flex flex-col justify-center items-center">
                <h4 class="text-center font-sans text-xs uppercase text-tan font-light mb-0">{{ $slide['sub_heading'] }}</h4>
                <h3 class="heading font-sans tracking-wide font-normal text-3xl uppercase text-center mb-0 leading-none">{{ $slide['heading'] }}</h3>
                @if ($i == 3)
                  <p class="extra-info text-center font-serif font-light text-tan text-normal pt-2 mb-0">
                    {{ $slide['text'] }}
                  </p>
                @endif
              </div>
            </div>
          </a>
        </div>
      @endif
    @endforeach
  </div>
  --}}
</section>
