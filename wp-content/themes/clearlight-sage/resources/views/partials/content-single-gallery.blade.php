@include('partials.page-header')

<article @php(post_class())>
  <section class="background-white">
    <div class="container">
      <div class="row">
        <div class="col l9">
          @php(the_content())
        </div>
      </div>
    </div>
  </section>

  <section class="background-frosty-green">
    <div class="container">
      <div class="row">
        <div class="col s12 gallery" id="bricks">
          @php
            $images = get_field('photos');
          @endphp

          @if($images)
            @foreach($images as $image)
              <div class="child">
                <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
              </div>
            @endforeach
          @endif
        </div>
      </div>

      <div class="row hentry">
        <div class="col l9">
          <p>Disclaimer: Our installers are amazing &mdash; but they’re not photographers! And while these photos are not the best quality, we hope they will give you an idea of Clearlight's capabilities.</p>
        </div>
      </div>
    </div>
  </section>
</article>
