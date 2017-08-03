<article @php(post_class('container'))>
  <div class="entry-content">

    <div class="row">
      <div class="col l6">
        @php(the_content())
      </div>
    </div>

    <div class="gallery">
      @php
        $images = get_field('photos');
        shuffle($images);
      @endphp

      @if($images)
        <ul>
          @foreach($images as $image)
            <li>
              <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</article>
