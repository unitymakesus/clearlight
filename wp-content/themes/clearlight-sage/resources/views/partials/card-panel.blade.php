@foreach ($cards as $card)
<div class="col s12 m6 l3">
  <div class="card-panel background-dark-green {{ $card['class'] }}">
    <a href="{!! $card['link'] !!}" class="mega-link" aria-hidden="true"></a>
    <div class="small-icon">{!! file_get_contents($card['img']) !!}</div>
    <h3>{!! $card['title'] !!}</h3>
    <p>{{ $card['text'] }}</p>
    <p><a class="link" aria-label="Learn more about our {{ $card['title'] }}">Learn More</a></p>
  </div>
</div>
@endforeach
