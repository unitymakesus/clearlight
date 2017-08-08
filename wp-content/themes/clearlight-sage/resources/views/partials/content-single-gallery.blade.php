<article @php(post_class('container'))>
  <div class="entry-content">

    <div class="row">
      <div class="col m8">
        @php(the_content())
      </div>

      <div class="col m3 offset-m1">
        @php
          //GET OTHER GALLERIES
          $args = array(
            'post_type' => 'gallery',
            'title_li' => '',
            'depth' => 1
          );
        @endphp
        <div class="widget subpages card-panel background-dark-green">
          <h3 class="widgettitle">More Inspiration</h3>
          <ul class="pages-list">
            {{wp_list_pages($args)}}
          </ul>
        </div>
      </div>
    </div>

    <div class="gallery">
      @php
        $images = get_field('photos');
      @endphp

      @if($images)
        @php(shuffle($images))
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
