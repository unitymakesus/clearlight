@foreach ($cards as $card)
<div class="col s12 m6 l3">
  <div class="card-panel background-dark-green {{ $card['class'] }}">
    @if ($card['img'])
      <div class="small-icon">
        {{-- {{ App\svg_image($card['img']) }} --}}
      </div>
    @endif
    <h3>{!! $card['title'] !!}</h3>
    <p>{{ $card['text'] }}</p>
    @if ($card['link'])
      <p><a class="link" href="{!! $card['link'] !!}" aria-label="Learn more about our {{ $card['title'] }}">Learn More</a></p>
    @endif
  </div>
</div>
@endforeach
