@php
  $term = get_queried_object();
  $post_type = get_post_type();
  $flex = get_field('flexible_content', $term);
  //echo json_encode($term);
  $sample_menus = new WP_Query(array(
    'post_type' => $post_type,
    'orderby' => 'title',
    'order' => 'ASC',
    'tax_query' => array(
      array(
        'taxonomy' => $term->taxonomy,
        'field' => 'slug',
        'terms' => $term->slug
      )
    )
  ));
@endphp

@extends('layouts.main')

@section('content')
  @if (isset($term))
    @include('components.page-header', [
      'size' => 'sm', 
      'url' => get_field('header_image', $term)['url'],
      'subtitle' => 'Events',
      'title' => $term->name,
    ])
    <section class="event-types pb-16 pt-8">
      @include('partials.content', [
        'content' => $flex
      ])
      @if ($sample_menus->have_posts())
        <section class="sample-menus md:my-32 mt-12">
          <div class="sample-menus-wrap w-full h-full bg-orange md:py-24 pt-12">
            <div class="container">
              <h4 class="text-center text-white font-sans uppercase text-3xl px-4 leading-tight w-full font-hairline tracking-wide">
                {{ $term->name }}
              </h4>
              <p class="md:px-32 px-5 text-center text-white font-serif font-normal px-4 w-full text-base pt-5">
              {{ $term->description }}
              </p>
              <div class="menu-links flex md:flex-row flex-wrap flex-col w-full pt-16 pb-12" data-event-type={{ $term->term_id }}>
                @php($index = 0)
                @while ($sample_menus->have_posts()) @php $sample_menus->the_post() @endphp
                  <a href="{{ get_permalink($menu->ID) }}" class="modal-toggle menu-link-item md:w-1/3 w-full block md:p-1 p-4">
                    <div data-index="{{ $index }}" data-event-type="{{ $term->name }}" class="menu-link-target w-full md:h-64 h-32 bg-center bg-cover bg-no-repeat flex flex-col justify-center items-center" style="background-image: url({{ get_field('gallery')[0]['url'] }});">
                      <h4 class="sub-heading pt-4 px-16 font-sans text-white text-sm font-thin text-center uppercase mb-0 w-full">{{ get_field('event_type')->name }}</h4>
                      <h3 class="title text-2xl pb-4 px-10 text-white font-serif font-semibold italic text-center w-full">{{ get_the_title() }}</h3>
                    </div>
                  </a>
                  @php($index++)
                @endwhile
                @php(wp_reset_postdata())
              </div>
              @component('components.modal', ['hyperapp' => true])
              @endcomponent
            </div>
          </div>
        </section>
      @endif
      <section class="tips w-full md:pt-5 pt-24 pb-12">
        <h4 class="font-sans uppercase text-center text-green text-base font-thin tracking-wide">
          {{ get_field('tips', $term)['sub_title'] }}
        </h4>
        <h2 class="font-sans uppercase text-green text-center text-3xl font-thin tracking-wider">
          {{ get_field('tips', $term)['title'] }}
        </h2>
        @component('components.carousel', [
          'id' => 'tips-carousel',
          'className' => 'w-full',
          'controls' => !wp_is_mobile(),
          'nav' => true,
          'navPosition' => 'bottom',
          'navColor' => 'fill-grey',
          'data' => [
            'loop' => true,
          ]
        ])
          @foreach(get_field('tips', $term)['slides'] as $tip)
            <div class="tip">
              <div class="container-sm pb-12 pt-10 lg:px-0 md:px-16 px-4">
                <div class="flex md:flex-row flex-col">
                  <div
                    class="rounded-full bg-center bg-cover bg-no-repeat m-auto md:mb-0 mb-8 block md:pb-1/3 pb-1/2 md:w-1/3 w-1/2 h-auto"
                    style="background-image: url({{ $tip['image']['url'] }});"
                  ></div>
                  <div class="tip-text md:pl-10 md:w-2/3 w-full flex flex-col justify-center -mt-5">
                    <h3 class="font-sans uppercase tracking-huge font-xl font-thin text-green my-4">
                      {!! $tip['title'] !!}
                    </h3>
                    <div class="text-grey font-base font-serif font-base">
                      {!! $tip['text'] !!}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endcomponent
      </section>
    </section>
  @endif
@endsection
