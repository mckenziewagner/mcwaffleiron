@php($descriptors = $descriptors ?: false)
@if ($descriptors)
  @foreach ($descriptors as $key => $value)
    @php
      $myKey = $value->term_id;
      $id = 'meal_descriptor_' . $myKey;
      $title = get_term($myKey)->name;
      $color = get_field('color', $id);
      $acronym = get_field('acronym', $id);
    @endphp
    <div class="descriptor inline-block">
      <h2 class="font-sans text-white text-center text-base font-light mr-1 uppercase rounded-full" style="background-color: {{ $color }};">{{ $acronym }}</h2>
    </div>
  @endforeach
@endif
