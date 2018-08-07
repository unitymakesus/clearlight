<header class="banner">
  <nav class="container">
    <div class="nav-wrapper row">
      <a class="brand-logo" href="{{ home_url('/') }}" rel="home">
        @if (has_custom_logo())
          @php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo = wp_get_attachment_image_src( $custom_logo_id , 'clearlight-logo' );
            $logo_2x = wp_get_attachment_image_src( $custom_logo_id, 'clearlight-logo-2x' );
          @endphp
          <img src="{{ $logo[0] }}"
               srcset="{{ $logo[0] }} 1x, {{ $logo_2x[0] }} 2x"
               alt="{{ get_bloginfo('name', 'display') }}" width="189" height="90">
        @else
          {{ get_bloginfo('name', 'display') }}
        @endif
      </a>
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'right hide-on-med-and-down']) !!}
        <a href="#" data-activates="mobile-menu" id="mobile-menu-button" class="right button-collapse" aria-hidden="true"><i class="fa fa-bars"></i></a>
        <div aria-hidden="true">
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'side-nav hide-on-large-only', 'menu_id' => 'mobile-menu', 'walker' => new App\MobileNavWalker()]) !!}
        </div>
      @endif
    </div>
  </nav>

  <div class="banner-row">
    <p>We sadly announce the passing of Bob Johnson, our former owner who did so much to build a foundation for growth at Clearlight.  We invite you to celebrate Bob’s life with us and his family on Thursday, August 9th at the First Christian Church of Winston-Salem beginning at 2:00 p.m.  Bob and his family are tucked in our thoughts and prayers.</p>
  </div>
</header>
