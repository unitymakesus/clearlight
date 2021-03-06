{{-- Getting Started --}}
@if( !is_page('request-a-quote') )
  <section class="background-dark-green">
    <div class="container">
      <div class="row flex-grid">
        <div class="col s12 m6 l5">
          <h2>Ready to get started?</h2>
          <p class="size-medium">Contact us today to discover how we can make the perfect piece for your project.</p>
        </div>
        <div class="col s12 m5 l4 offset-l1 valign-wrapper">
          <a href="{{ get_permalink(get_page_by_path('request-a-quote')) }}" class="btn-large">Request a Custom Glass Quote</a>
        </div>
      </div>
    </div>
  </section>
@endif

<footer>
  <div class="footer-logos">
    <div class="container">
      <div class="row">
        @include('partials.footer-logos', [
          'logos'     => [
            [
              'src'   => App\asset_path('images/esourcebook.png'),
              'alt'   => 'eSourceBook',
              'link'  => 'https://www.esourcebook.net/united-states/kernersville/glass-industry-supplier/clearlight-glass-and-mirror/',
            ],
            [
              'src'   => App\asset_path('images/sgcc.png'),
              'alt'   => 'The Safety Glazing Certifiation Council',
              'link'  => 'https://www.sgcc.org/',
            ],
            [
              'src'   => App\asset_path('images/nahb.png'),
              'alt'   => 'National Association of Home Builders',
              'link'  => 'https://www.nahb.org/',
            ],
            [
              'src'   => App\asset_path('images/dfi.png'),
              'alt'   => 'Diamon Fusion International',
              'link'  => 'https://dfisolutions.com/',
            ],
            [
              'src'   => App\asset_path('images/homebuilders.png'),
              'alt'   => 'Home Builders Association of Winston Salem',
              'link'  => 'https://hbaws.net/',
            ],
            [
              'src'   => 'https://seal-nwnc.bbb.org/seals/blue-seal-200-42-clearlight-glass-mirror-inc-152800337.png',
              'alt'   => 'Better Business Bureau Review',
              'link'  => 'https://www.bbb.org/us/nc/kernersville/profile/beveled-glass/clearlight-glass-mirror-inc-0503-152800337',
            ],
          ],
        ])
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col s12 m12 l3">
        <a class="brand-logo" href="{{ home_url('/') }}" rel="home">
          @if (has_custom_logo())
            @php
              $custom_logo_id = get_theme_mod( 'custom_logo' );
              $logo = wp_get_attachment_image_src( $custom_logo_id , 'clearlight-logo' );
              $logo_2x = wp_get_attachment_image_src( $custom_logo_id, 'clearlight-logo-2x' );
            @endphp
            <img data-src="{{ $logo[0] }}"
                srcset="{{ $logo[0] }} 1x, {{ $logo_2x[0] }} 2x"
                alt="{{ get_bloginfo('name', 'display') }}">
          @else
            {{ get_bloginfo('name', 'display') }}
          @endif
        </a>
      </div>
      <div class="col s12 m6 l2">
        <div class="contact text-bold">
          <ul>
            <li>
              <a href="tel:+1-336-993-7300">336-993-7300</a><br />
                336-993-1431
            </li>
            <li>1318 Shields Road<br />Kernersville, NC 27284</li>
            <li><a href="{{ get_permalink(get_page_by_path('about/contact')) }}" class="contact-us">Contact Us ›</a></li>
          </ul>
        </div>
      </div>
      <div class="col s12 m6 l3">
        <p>We are consistently delivering to our customers throughout North Carolina, South Carolina, and Virgina.</p>
        <p>We will work with you to ship your project anywhere you need. Please contact us to discuss shipping options.</p>
      </div>
      <div class="col s12 m12 l4">
        <a href="{{ get_permalink(get_page_by_path('about/contact')) }}">
          <img src="{{ App\asset_path('images/footer-service-area-map.png') }}" alt="Contact Us"/>
        </a>
      </div>
    </div>
    <div class="row copyright">
      <div class="col s12 m4">
        <a href="/wp-content/uploads/2021/04/X190904-Terms-and-Conditions.pdf">Terms &amp; Conditions</a> &nbsp; <a href="{{ get_permalink(get_page_by_path('privacy-policy')) }}">Privacy Policy</a>
      </div>
      <div class="col s12 m4 center-align">
        &copy; {{ current_time('Y') }} Clearlight Glass &amp; Mirror. All rights reserved.
      </div>
      <div class="col s12 m4 text-right-l">
        <a href="https://unitywebagency.com">Powered By Unity</a>
      </div>
    </div>
  </div>
</footer>
