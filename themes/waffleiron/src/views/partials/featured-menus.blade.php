<section class="featured-menus md:my-32 -my-1">
  <div class="featured-menus-wrap w-full h-full bg-orange md:py-24 py-16">
    <div class="container">
      <h4 class="text-center text-white font-sans uppercase text-3xl px-4 leading-tight w-full font-hairline tracking-wide">
        {{ get_sub_field('title') }}
      </h4>
      <p class="md:px-32 px-5 text-center text-white font-serif font-normal px-4 w-full text-base pt-5">
        {{ get_sub_field('text') }}
      </p>
      <div class="menu-links flex md:flex-row flex-wrap flex-col w-full pt-16 pb-12">
        @foreach (get_sub_field('menus') as $menu)
          <a href="{{ get_permalink($menu->ID) }}" class="menu-link-item md:w-1/3 w-full block p-1">
            <div class="w-full md:h-64 h-32 bg-center bg-cover bg-no-repeat flex flex-col justify-center items-center" style="background-image: url({{ get_field('gallery', $menu->ID)[0]['url'] }});">
              <h4 class="sub-heading pt-4 px-16 font-sans text-white text-sm font-thin text-center uppercase mb-0 w-full">{{ get_field('event_type', $menu->ID)->name }}</h4>
              <h3 class="title text-2xl pb-4 px-10 text-white font-serif font-semibold italic text-center w-full">{{ get_the_title($menu->ID) }}</h3>
            </div>
          </a>
        @endforeach
        <a href="/events/weddings" class="show-all menu-link-item md:w-1/3 w-full block p-1">
          <div class="w-full md:h-64 h-32 bg-center bg-cover bg-no-repeat flex flex-col justify-center items-center" style="background-image: url(https://www.placehold.it/1920x1080);">
            <h4 class="sub-heading font-sans text-white text-2xl tracking-wide font-thin text-center uppercase m-0 rounded-full border-2 border-white border-solid">See All Menu Samples</h4>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>
