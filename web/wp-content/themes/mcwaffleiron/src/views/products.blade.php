@extends('layouts.main')

@php
  $boxed_posts = get_posts(array(
    'name'        => 'boxed-meals',
    'post_type'   => 'page',
    'post_status' => 'publish',
    'numberposts' => 1,
  ));
  $togo = wc_get_products(array(
    'return' => 'ids',
    'limit' => -1,
    'category' => array('boxed-meals'),
  ));
  $boxed_meals = array(
    'title' => get_the_title($boxed_posts[0]->ID),
    'dynamic_layouts' => get_field('dynamic_layouts', $boxed_posts[0]->ID),
    'togo' => array(),
  );
  foreach ($togo as $id) {
    $type = get_field('boxed_lunch_type', $id);
    $boxed_meals['togo'][$type->slug][] = array(
      'title' => get_the_title($id),
      'price' => get_field('_price', $id),
      'category' => get_field('type', $id),
      'tag' => get_field('boxed_lunch_type', $id),
      'description' => get_field('description', $id),
      'options' => get_field('options', $id),
    );
    $boxed_meals['togo'][$type->slug]['title'] = $type->name;
    $boxed_meals['togo'][$type->slug]['text'] = get_field('text', 'product_tag_'.$type->term_id);
    $boxed_meals['togo'][$type->slug]['image'] = get_field('image', 'product_tag_'.$type->term_id)['url'];
  }
@endphp

@section('content')

  @if (isset($boxed_meals['dynamic_layouts']))
    @foreach ($boxed_meals['dynamic_layouts'] as $layout)
      <script>console.log({!! json_encode($boxed_meals) !!})</script>
      @if ($layout['acf_fc_layout'] === 'header')
        @include('components.page-header', array(
          'size' => 'sm',
          'url' => $layout['image']['url'],
          'subtitle' => 'Classics To-Go',
          'title' => $boxed_meals['title'],
        ))
      @endif

      @if ($layout['acf_fc_layout'] === 'content')
        @include('partials.content', array(
          'content' => [$layout],
        ))
      @endif

      @if ($layout['acf_fc_layout'] === 'call_to_action_with_copy')
        @include('partials.call-to-action-with-copy')
      @endif

      @if ($layout['acf_fc_layout'] === 'call_out')
        @include('partials.call-out')
      @endif

      @if ($layout['acf_fc_layout'] === 'contact')
        @include('partials.contact')
      @endif

      @if ($layout['acf_fc_layout'] === 'featured_menus')
        @include('partials.featured-menus')
      @endif

      @if ($layout['acf_fc_layout'] === 'call_to_action_buttons')
        @include('partials.call-to-action-buttons')
      @endif

      @if ($layout['acf_fc_layout'] === 'testimonial_carousel')
        @include('partials.testimonial-carousel')
      @endif

      @if ($layout['acf_fc_layout'] === 'menus')
        @include('partials.menus')
      @endif

    @endforeach
  @endif

  <div id="boxed-lunch-controls" class="w-full h-full container flex flex-row justify-between items-center">
    @foreach ($boxed_meals['togo'] as $key => $val)
      @php(
        $url = $boxed_meals['togo'][$key]['image']
      )
      <script>console.log({!! json_encode($boxed_meals['togo'][$key]['image']) !!})</script>
      <a id="CONTROL-{{ $key }}" href="/events/weddings" class="menu-link-item md:w-1/3 w-full block px-10">
        <div class="hover:border-orange border-transparent border-b-32 border-solid relative w-full h-full bg-center bg-cover bg-no-repeat flex flex-col justify-center items-center" style="background-image: url({{ $url }});">
          <h2 class="z-20 relative flex flex-col bg-white text-grey sub-heading font-sans text-4xl relative px-2 tracking-wide font-thin text-center uppercase m-0 rounded-full border-2 border-white border-solid">
            <span class="text-xs text-grey-light tracking-wide block">Order the</span>
            {{ ucwords(str_replace('-', ' ', $key)) }}
          </h2>
        </div>
      </a>
    @endforeach
  </div>

  <div id="boxed-lunches" class="w-full h-full mt-12 bg-orange pb-48 relative">
    @foreach ($boxed_meals['togo'] as $key => $val)
      <div class="w-full pin {{ $loop->first ? 'visible opacity-100 relative' : 'invisible opacity-0 absolute' }}" id="ITEM-{{ $key }}">
        <div class="list w-full h-full">
          <div class="container px-12">
            <h2 class="text-white font-sans uppercase text-center text-2xl tracking-wider font-light pt-24">{{ $val['title'] }} Lunches</h2>
            <div class="text-white font-serif text-center py-4">{!! $val['text'] !!}</div>
            <div class="w-full flex flex-row flex-wrap pt-24">
              @foreach ($boxed_meals['togo'][$key] as $key => $item)
                @if (is_array($item))
                  <div class="boxed-lunch-item relative md:w-1/2 w-full {{ $loop->index % 2 == 0 || $loop->first ? 'pr-12' : 'pl-12' }} mb-12">
                    <h3 class="flex flex-row justify-center items-between w-full text-white font-sans tracking-wider font-light uppercase text-2xl leading-normal">
                      {{ $item['title'] }}
                      <span class="price ml-auto text-base tracking-normal">
                        ${{ $item['price'] }}
                      </span>
                    </h3>
                    <div class="desc text-white font-serif text-base font-light leading-normal pb-6 pt-4">
                      {!! $item['description'] !!}
                    </div>
                    <button class="text-xl uppercase font-sans tracking-wider py-2 px-8 text-white border-2 border-solid border-yellow mt-4 hover:bg-yellow">Add to Order</button>
                    <div class="relative border-b-1 border-grey-lighter border-solid w-full leading-none pt-8"></div>
                  </div>
                @endif
              @endforeach  
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

@endsection
