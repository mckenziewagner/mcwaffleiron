<section class="call-to-action-buttons">
  <div class="call-to-action-buttons-wrap md:my-32 relative">
    <div class="container-right bg-yellow"></div>
    <div class="container relative py-16">
      <div class="container-right-comp bg-yellow"></div>
        <h1 class="md:px-0 px-5 text-green font-serif italic uppercase text-5xl pb-5 leading-tight font-semibold tracking-wide">
          {{ get_sub_field('title') }}
        </h1>
        <p class="md:px-0 px-5 text-green font-serif font-normal text-base">
          {!! get_sub_field('text') !!}
        </p>
        <div class="flex md:flex-row flex-col pt-16">
          <a
            href="{{ get_sub_field('left_button')['page'] }}"
            class="flex flex-row justify-center items-center w-full h-full left-col block bg-center bg-no-repeat bg-cover"
            style="background-image: url({{ get_sub_field('left_button')['image']['url'] }});"
          >
            <div class="round-button flex flex-col rounded-full p-20 m-20 md:w-72 md:h-72 w-48 h-48 justify-center items-center">
              <h3 class="title text-white font-sans uppercase tracking-wide leading-tight text-3xl text-center mb-0">
                {{ get_sub_field('left_button')['title'] }}
              </h3>
            </div>
          </a>
          <a
            href="{{ get_sub_field('right_button')['page'] }}"
            class="flex flex-row justify-center items-center w-full h-full left-col block bg-center bg-no-repeat bg-cover"
            style="background-image: url({{ get_sub_field('right_button')['image']['url'] }});"
          >
            <div class="round-button flex flex-col rounded-full p-20 m-20 md:w-72 md:h-72 w-48 h-48 justify-center items-center">
              <h3 class="title text-white font-sans uppercase tracking-wide leading-tight text-3xl text-center mb-0">
                {{ get_sub_field('right_button')['title'] }}
              </h3>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
