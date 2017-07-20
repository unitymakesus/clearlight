<footer>
  <div class="find-us">
    <div class="contact-info">
      <ol>
        <li>
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
        </li>
        <li><img src="./images/phone-icon.png" alt="Phone Number" class="footer-icon"><tel>336-993-7300</tel></li>
        <li><img src="./images/fax-icon.png" alt="Fax Number" class="footer-icon">336-993-1431</li>
        <li>1318 Shields Road<br />Kernersville, NC 27284</li>
        <li><a href="{{ get_permalink(get_page_by_path('contact')) }}" class="contact-us">Contact Us ›</a></li>
    </div>

    <div class="map">
      <img src="./images/map.png" alt="Location Map">
    </div>
  </div>

  <div class="proud-member">
    <span class="members-of">PROUD MEMBERS OF:</span>
    <div class="member-list">
      <ol>
        <li><img src="./images/homebuilders.png" alt="Home Builders Association of Winston Salem"></li>
        <li><img src="./images/nc.png" alt="North Carolina Home Builders Association"></li>
        <li><img src="./images/gborobuilders.png" alt="Greensboro Builders Association"></li>
        <li><img src="./images/nahb.png" alt="National Association of Home Builders"></li>
        <li><img src="./images/BBB.png" alt="Better Business Bureau Rating"></li>
      </ol>
    </div>
  </div>

  <div class="footer-copyright">
    <div class="container">
    &copy; {{ current_time('Y') }} Clearlight Glass &amp; Mirror. All rights reserved.
    </div>
  </div>
</footer>
