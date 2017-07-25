@foreach ($cards as $card)
<div class="col">
  <div class="card z-depth-1">
    <a href="#" class="card-image">
      <img src="{!! $card['img'] !!}" alt="" />
      <div class="valign-wrapper">
        <span class="card-title">{!! $card['title'] !!}</span>
      </div>
    </a>
  </div>
</div>
@endforeach
