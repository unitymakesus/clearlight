@foreach ($cards as $card)
<div class="col s12 m6 l3">
  <div class="card-panel background-dark-green {!! $card['class'] !!}">
    <a href="{!! $card['link'] !!}" class="mega-link"></a>
    <div class="small-icon">{!! file_get_contents($card['img']) !!}</div>
    <h3>{!! $card['title'] !!}</h3>
    <p>{!! $card['text'] !!}</p>
    <p class="learn-more">Learn More</p>
  </div>
</div>
@endforeach
