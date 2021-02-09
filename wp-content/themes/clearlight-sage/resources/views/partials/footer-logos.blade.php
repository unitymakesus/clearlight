@foreach ($logos as $logo)
  <a class="footer-logos__wrap" href="{{ $logo['link'] }}" target="_blank" rel="noopener">
    @include('partials.lazy-image', [
      'src' => $logo['src'],
      'alt' => $logo['alt'],
    ])
  </a>
@endforeach
