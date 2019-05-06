<footer>
  <div class="contact bg-yellow pt-24 pb-32">
    <div class="container-sm">
      <h3 class="font-serif text-grey text-center italic pb-5 font-semibold font-base my-0">
        {{ get_field('title', 'options') }}
      </h3>
      <p class="font-serif text-grey text-center pb-10 font-sm font-normal mx-auto max-w-md">
        {!! get_field('text', 'options') !!}
      </p>
      @include('partials.big-button', array(
        'heading' => get_field('button', 'options')['text'],
        'subheading' => get_field('button', 'options')['sub_heading'],
        'link' => get_field('button', 'options')['page'],
        'heading_color' => '#808184',
        'subheading_color' => 'white',
        'shadow_color' => '#ce6e19'
      ))
    </div>
  </div>
  <div class="footer bg-white pt-12 pb-32 w-full">
    <div class="container-sm flex lg:flex-row flex-col-reverse lg:justify-start justify-center w-full pb-10">
      <div class="flex flex-col lg:justify-between justify-center info lg:w-3/4 w-full">
        <h3 class="text-grey font-serif font-base mt-10 font-light lg:text-left text-center lg:pb-0 pb-5">{!! get_field('tagline', 'options') !!}</h3>
        <h3 class="text-orange uppercase font-sans font-base mb-12 font-normal lg:text-left text-center leading-normal">
          <a class="text-orange hover:text-orange-darker md:pb-0 mb-2" href="tel:+1{{get_field('phone_number', 'options')}}">{{ format_phone(get_field('phone_number', 'options')) }}</a>
          <span class="inline-block tracking-tight mx-4 md:inline-block hidden"> // </span>
          <a class="text-orange hover:text-orange-darker" href="mailto:+1{{get_field('email', 'options')}}">{{ get_field('email', 'options') }}</a>
        </h3>
        <div class="flex lg:flex-row flex-col items-center lg:justify-start justify-center mt-1">
          <div class="flex flex-row items-center lg:mr-6 lg:pb-0 pb-4">
            <a href="{{ get_field('social_media', 'options')['facebook'] }}" class="fill-orange hover:fill-orange-dark w-10">@include('svg.facebook')</a>
            <a href="{{ get_field('social_media', 'options')['twitter'] }}" class="fill-orange hover:fill-orange-dark mx-6 w-10">@include('svg.twitter')</a>
            <a href="{{ get_field('social_media', 'options')['instagram'] }}" class="fill-orange hover:fill-orange-dark w-10">@include('svg.instagram')</a>
          </div>
          <a class="border-2 px-4 py-2 -mt-1 font-bold text-sm font-normal text-grey-light border-grey-light hover:bg-grey-light hover:text-white font-serif uppercase italic" href="#">
            Employment Opportunities
          </a>
        </div>
      </div>
      <div class="logo lg:w-1/4 w-full text-center">
        <img class="w-full max-w-56" src="{{ get_field('logo', 'options')['url'] }}" alt="">
      </div>
    </div>
    <div class="container-sm">
      <h5 class="copyright text-grey-light font-serif text-xs pb-4 my-0 font-light lg:text-left text-center">
        © {{ date("Y") }} Classic Events Catering
      </h5>
      <h5 class="font-light copyright text-grey-light font-serif text-xs my-0 lg:text-left text-center">
        Consumer Advisory
      </h5>
      <p class="consumer-advisory text-grey-light font-serif text-xs lg:text-left text-center">
        {!! get_field('consumer_advisory', 'options') !!}
      </p>
    </div>
  </div>
</footer>
