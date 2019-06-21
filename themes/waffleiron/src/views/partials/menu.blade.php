@php
  $meal_ids = get_field('meals');
  $meal_types = get_terms('meal_types');
  $meals = array();
  foreach ($meal_ids as $id) {
    $new_meal = array(
      'title' => get_the_title($id),
      'meal_type' => get_field('meal_type', $id),
      'meal_descriptor' => get_field('meal_descriptor', $id),
      'description' => get_field('description', $id),
    );
    $meals[] = $new_meal;
  }
  $filtered_meals = [];
  foreach ($meals as $meal) {
    $slug = $meal['meal_type']->slug;
    $name = $meal['meal_type']->name;
    $filtered_meals[$name][] = $meal;
  }
  $reverse_meals = array_reverse($filtered_meals);
  $reverse_meals = array_filter($reverse_meals); 
  $filtered_descriptors = [];
  foreach ($meals as $meal) {
    $descriptors = $meal['meal_descriptor'];
    if (empty($descriptors)) { continue; }
    foreach ($descriptors as $descriptor) {
      $filtered_descriptors[$descriptor->term_id][] = $meal;
    }
  }
@endphp

<script>
  //console.log({!! json_encode($filtered_meals) !!})
  //console.log({!! json_encode($filtered_descriptors) !!})
</script>

<section class="single-menu md:py-32 py-12 relative">

  <div style="height: 100px;" class="bg-yellow absolute container z-0 pin-x"></div>
  <div style="height: 100px;" class="relative z-10 container menu-controls relative bg-transparent border-4 border-orange border-solid h-full">
    <div class="z-20 flex flex-col justify-center items-center w-full h-full p-10">
      <h3 class="font-sans text-base font-light tracking-wider uppercase text-orange relative">Jump to Section</h3>
      <div class="relative menu-anchors flex flex-row justify-center items-center mt-1">
        @foreach ($reverse_meals as $filter => $meal)
          <a href="#FILTER-{{ $filter }}" class="font-sans hover:opacity-75 tracking-wider text-2xl uppercase text-orange px-6">
            {{ $filter }}
          </a>
        @endforeach
      </div>
    </div>
  </div>

  <div class="legend relative">
    <div class="flex flex-row items-center justify-center w-full h-full relative py-12">
      @foreach ($filtered_descriptors as $key => $value)
        @php
          $id = 'meal_descriptor_' . $key;
          $title = get_term($key)->name;
          $color = get_field('color', $id);
          $acronym = get_field('acronym', $id);
        @endphp
        <div class="descriptor p-5 flex flex-row items-center justify-center">
          <h2 class="font-sans text-white text-center text-base font-light mr-1 uppercase rounded-full" style="background-color: {{ $color }};">{{ $acronym }}</h2>
          <h3 class="font-sans tracking-wide text-xl uppercase font-thin" style="color: {{ $color }};">{{ $title }}</h3>
        </div>
      @endforeach
    </div>
  </div>

  <div class="meals">
    <div class="flex flex-col container-sm w-full h-full">
      @foreach ($reverse_meals as $filter => $meal)
        <div id="FILTER-{{ $filter }}" class="meal">
          <h2 class="meal-type-title mb-4 font-sans tracking-wider meal-title w-full border-b-2 border-orange border-solid text-3xl font-normal uppercase text-orange">{{ $filter }} <span class="text-base font-normal tracking-wide">{{ get_the_title() }}</span></h2>
          @foreach (get_field('meals') as $meal)
            <div class="inline-descriptor py-4">
              <span class="text-black leading-tight font-serif inline">{!! get_the_title($meal) !!}</span>
              @include('components.descriptor', array('descriptors' => get_field('meal_descriptor', $meal)))
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
  </div>

  <nav id="footer-nav" class="opacity-0 invisible z-50 bg-white fixed pin-l pin-b w-full h-12 border-t-1 border-b-1 border-orange border-solid">
    <div class="container-sm flex flex-row h-full">
      <a id="menus-back" href="/our-food" class="hover:opacity-75 w-1/4 h-full flex flex-row items-center justify-center font-sans uppercase tracking-wide font-thin text-orange text-lg border-l-1 border-orange">Menus</a>
      <a id="print" href="#" class="w-1/4 h-full flex flex-row items-center justify-center font-sans uppercase tracking-wide font-thin text-orange text-lg border-l-1 border-orange">Print</a>
      <a id="share" target="_blank" rel="noreferrer" href="https://www.facebook.com/sharer/sharer.php?u=https%3A//www.facebook.com/classiceventscatering/" class="w-1/4 h-full flex flex-row items-center justify-center font-sans uppercase tracking-wide font-thin text-orange text-lg border-l-1 border-orange">Share</a>
      <a id="top" href="#" class="w-1/4 h-full flex flex-row items-center justify-center font-sans uppercase tracking-wide font-thin text-orange text-lg border-l-1 border-r-1 border-orange">Top</a>
    </div>
  </nav>

</section>
