{{-- Getting Started --}}
<section class="background-dark-green">
  <div class="container">
    <div class="row flex-grid">
      <div class="col s12 m6 l5">
        <h2>Ready to get started?</h2>
        <p class="size-medium">Contact us today to discover how we can make the perfect piece for your project.</p>
      </div>
      <div class="col s12 m5 l4 offset-l1 valign-wrapper offset-">
        <a href="#" class="btn-large" href="#">Request a Quote</a>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="row">
      <div class="col s6 m5 l4">
        <a class="brand-logo" href="{{ home_url('/') }}" rel="home">
          @if (has_custom_logo())
            @php
              $custom_logo_id = get_theme_mod( 'custom_logo' );
              $logo = wp_get_attachment_image_src( $custom_logo_id , 'clearlight-logo' );
              $logo_2x = wp_get_attachment_image_src( $custom_logo_id, 'clearlight-logo-2x' );
            @endphp
            <img src="{{ $logo[0] }}"
                 srcset="{{ $logo[0] }} 1x, {{ $logo_2x[0] }} 2x"
                 alt="{{ get_bloginfo('name', 'display') }}">
          @else
            {{ get_bloginfo('name', 'display') }}
          @endif
        </a>

        <ul class="size-medium">
          <li>
            <i class="fa fa-phone" aria-label="Phone"></i> <tel>336-993-7300</tel><br />
            <i class="fa fa-fax" aria-label="Fax"></i> 336-993-1431
          </li>
          <li>1318 Shields Road<br />Kernersville, NC 27284</li>
          <li><a href="{{ get_permalink(get_page_by_path('contact')) }}" class="contact-us">Contact Us ›</a></li>
        </ul>
      </div>

      <div class="col s6 m7 l8">
        <img src="./images/map.png" alt="Location Map">
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="h6 uppercase">Proud Members Of:</div>
      </div>
    </div>

    <div class="row block-grid up-s1 up-m3 up-l5">
      <div class="col"><img src="{{ App\asset_path('images/homebuilders.png') }}" alt="Home Builders Association of Winston Salem"></div>
      <div class="col"><img src="{{ App\asset_path('images/nc.png') }}" alt="North Carolina Home Builders Association"></div>
      <div class="col"><img src="{{ App\asset_path('images/gborobuilders.png') }}" alt="Greensboro Builders Association"></div>
      <div class="col"><img src="{{ App\asset_path('images/nahb.png') }}" alt="National Association of Home Builders"></div>
      <div class="col"><img src="{{ App\asset_path('images/BBB.png') }}" alt="Better Business Bureau Rating"></div>
    </div>

    <div class="row">
      <div class="col s12 m6 l4">
        <a href="#">Terms &amp; Conditions</a> &nbsp; <a href="#">Privacy Policy</a>
      </div>
      <div class="col s12 m6 l4 center-align">
        &copy; {{ current_time('Y') }} Clearlight Glass &amp; Mirror. All rights reserved.
      </div>
      <div class="col s12 l4 right-align">
        @include('partials.unity')
      </div>
    </div>
  </div>
</footer>
