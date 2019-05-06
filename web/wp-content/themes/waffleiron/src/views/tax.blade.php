@php
  global $post;
  $term = get_queried_object();
  $termContent = get_field('tips', $term);
@endphp

@extends('layouts.main')

@section('content')
  {{-- json_encode($post) --}}
  {{-- get_field('event_type') --}}
  {{ $termContent[''][] }}
{{--
  @if (have_posts())
    @while (have_posts())
      <div class="ok">ok</div>
    @endwhile
  @endif
--}}
@endsection
