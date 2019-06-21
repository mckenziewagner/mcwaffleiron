@extends('layouts.main')

@section('content')

  @if (get_field('header'))
    @include('components.page-header', [
      'size' => get_field('style')['type'] ? 'half' : 'sm',
      'url' => get_field('header')['image']['url'],
      'title' => get_the_title(),
      'overlay' => get_field('header')['overlay_color'],
    ])
  @endif

  @if (get_field('intro'))
    @include('partials.content', array(
      'content' => [[
        'text' => get_field('intro')['text'],
        'image' => get_field('intro')['image'],
        'style' => array(
          'text_color' => '#ce6e19',
          'flip' => false,
        ),
      ]],
    ))
  @endif

  @if (get_field('meals'))
    @include('partials.menu')
  @endif

@endsection
