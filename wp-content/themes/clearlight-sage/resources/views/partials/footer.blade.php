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
          <a href="{{ get_permalink(get_page_by_path('request-a-quote')) }}" class="btn-large">Request a Quote</a>
        </div>
      </div>
    </div>
  </section>
@endif

<footer>
  <div class="container">
    <div class="row">
      <div class="col s12 m5 l4">
        <a class="brand-logo hide-on-small-only" href="{{ home_url('/') }}" rel="home">
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

        <ul class="size-medium">
          <li>
            <i class="fa fa-phone" aria-label="Phone"></i> <a href="tel:+1-336-993-7300">336-993-7300</a><br />
            <i class="fa fa-fax" aria-label="Fax"></i> 336-993-1431
          </li>
          <li>1318 Shields Road<br />Kernersville, NC 27284</li>
          <li><a href="{{ get_permalink(get_page_by_path('about/contact')) }}" class="contact-us">Contact Us ›</a></li>
        </ul>
      </div>

      <div class="col s12 m7 l8">
        {!! do_shortcode ('[wpgmza id="1"]') !!}
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="h6 uppercase">Proud Members Of:</div>
      </div>
    </div>

    <div class="row block-grid up-s12 up-m3 up-l5 align-center">
      @include('partials.footer-logos', [
        'logos'     => [
          [
            'src'   => App\asset_path('images/homebuilders.png'),
            'alt'   => 'Home Builders Association of Winston Salem',
            'link'  => 'http://hbaws.net/',
          ],
          [
            'src'   => App\asset_path('images/nc.png'),
            'alt'   => 'North Carolina Home Builders Association',
            'link'  => 'https://www.nchba.org/wp/',
          ],
          [
            'src'   => App\asset_path('images/gborobuilders.png'),
            'alt'   => 'Greensboro Builders Association',
            'link'  => 'https://www.greensborobuilders.org/',
          ],
          [
            'src'   => App\asset_path('images/dfi.png'),
            'alt'   => 'Diamon Fusion International',
            'link'  => 'https://dfisolutions.com/',
          ],
          [
            'src'   => App\asset_path('images/NAHB.png'),
            'alt'   => 'National Association of Home Builders',
            'link'  => 'https://www.nahb.org/',
          ],
        ]
      ])
      <div class="col">
        <a href="https://www.houzz.com/pro/chammondcl/clearlight-glass-and-mirror" target="_blank" rel="noopener">
          <img alt="Clearlight Glass and Mirror is Recommended on Houzz" src="https://st.hzcdn.com/static/badge_20_9@2x.png" width="96" height="96" />
        </a>
      </div>
      <div class="col">
        <a href="http://www.bbb.org/northwestern-north-carolina/business-reviews/glass-beveled-carved-ornamental/clearlight-glass-mirror-inc-in-kernersville-nc-152800337/#bbbonlineclick" target="_blank" rel="noopener">
          <img alt="Better Business Bureau Review" src="http://seal-nwnc.bbb.org/seals/blue-seal-200-42-clearlight-glass-mirror-inc-152800337.png" />
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col s12 m4">
        <a href="/wp-content/uploads/2017/08/ClearlightTermsAndConditions.pdf">Terms &amp; Conditions</a> &nbsp; <a href="{{ get_permalink(get_page_by_path('privacy-policy')) }}">Privacy Policy</a>
      </div>
      <div class="col s12 m4 center-align">
        &copy; {{ current_time('Y') }} Clearlight Glass &amp; Mirror. All rights reserved.
      </div>
      <div class="col s12 m4 right-align">
        @include('partials.unity')
      </div>
    </div>
  </div>
</footer>
