<section class="call-to-action-with-copy">
  <div class="call-to-action-with-copy-wrap md:my-32 relative">
    <div class="container-left bg-yellow"></div>
    <div class="container-sm relative">
      <div class="container-left-comp bg-yellow"></div>
      <div class="flex md:flex-row flex-col md:justify-start justify-center pt-24 z-10">
        <div class="left-col md:w-1/3 w-full md:pr-4">
          <h4 class="text-green font-sans uppercase text-2xl leading-tight font-hairline tracking-wide">
            {{ get_sub_field('title') }}
          </h4>
          <h5 class="text-orange font-serif italic text-lg font-semibold leading-tight tracking-wide py-6">
            {!! get_sub_field('tagline') !!}
          </h5>
        </div>
        <div class="right-col md:w-2/3 w-full md:pl-12 font-serif text-green text-base font-normal leading-normal">
          {!! get_sub_field('text') !!}
        </div>
      </div>
      <div class="pt-16 md:pb-32 pb-24 z-10">
        @include('partials.big-button', array(
          'heading' => get_sub_field('link')['heading'],
          'subheading' => get_sub_field('link')['sub_heading'],
          'link' => get_sub_field('link')['page'],
          'bg_color' => 'white',
          'heading_color' => '#384b00',
          'subheading_color' => '#ce6e19',
          'shadow_color' => '#384b00'
        ))
      </div>
    </div>
  </div>
</section>
