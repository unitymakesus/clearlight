@foreach ($logos as $logo)
  <div class="col">
    <a href="{{ $logo['link'] }}" target="_blank" rel="noopener">
      @include('partials.lazy-image', [
        'src' => $logo['src'],
        'alt' => $logo['alt'],
      ])
    </a>
  </div>
@endforeach
