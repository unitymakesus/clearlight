@extends('layouts.app')

@section('content')

  {{-- Hero --}}
  <section class="hero">
    <div class="background-video" id="video-blur-wrapper"
      data-poster="{{ App\asset_path('images/hero-blur-poster.jpg') }}"
      data-mp4="{{ App\asset_path('images/hero-blur-min.mp4') }}"
      data-webm="{{ App\asset_path('images/hero-blur-min.webm') }}">
      <img class="fallback" src="{{ App\asset_path('images/hero-blur-poster.jpg') }}" alt="" />
    </div>
    <div class="background-video sharp" id="video-sharp-wrapper"
      data-poster="{{ App\asset_path('images/hero-poster.jpg') }}"
      data-mp4="{{ App\asset_path('images/hero-min.mp4') }}"
      data-webm="{{ App\asset_path('images/hero-min.webm') }}">
      <img class="fallback" src="{{ App\asset_path('images/hero-poster.jpg') }}" alt="CNC machine cutting glass with water spraying" />
    </div>

    <div class="hero-text">
      <div class="container">
        <div class="row">
          <div class="col s12 m9 l7">
            <h1>Protective Barrier Systems For COVID-19 Safety & Containment</h1>
            <p>Clearlight is helping fight the spread of the virus by offering protective barriers or sneeze guards in office reception and work areas for the medical, dental and professional communities in North Carolina and nationwide as they reopen. We offer barriers in acrylic (plexiglass) and glass that are either moveable or permanent.</p>
            <a class="btn-large" href="{{ get_permalink(get_page_by_path('protective-barrier-systems-for-covid-19')) }}">Click here to explore barrier options!</a>
            <a class="btn-large" href="tel:1-336-993-7300">Call now 336-993-7300</a>
          </div>
        </div>
      </div>
      <div class="flex-ribbons">
        <div class="container">
          <div class="flex-ribbons__inner">
            <div>
              <a href="https://www.clearlightglass.com/wp-content/uploads/2019/01/X181213-Proof-of-North-Carolina-Construction-News-Article.pdf" target="_blank" rel="noopener noreferrer">
                <img src="{{ App\asset_path('images/ribbon-top-10-industry-white.png') }}" alt="Top 10 Industry Leader, by North Carolina Construction News for Shower and Mirror Work" />
              </a>
            </div>
            <div>
              <a href="https://www.clearlightglass.com/wp-content/uploads/2020/04/PGI_01_ID147837031_341cb6190ed80f1622f01bb2f3f0a6fb.jpg" target="_blank" rel="noopener noreferrer">
                <img src="{{ App\asset_path('images/ribbon-2020-top-glass-fab-white.png') }}" alt="{{ __('2020 Top Glass Fabricator, Natural Glass Association’s Glass Magazine') }}" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Customization tiles --}}
  <section class="background-frosty-to-white">
    <div class="container" style="position:relative;">
    </div>
    <div class="container">
      <div class="row block-grid up-s2 up-m3 up-l6">
        @include('partials.card-image', [
          'cards'     => [
            [
              'img'   => App\asset_path('images/custom-shapes.jpg'),
              'title' => 'Custom Shapes',
              'link'  => get_permalink(get_page_by_path('capability/custom-shapes'))
            ],
            [
              'img'   => App\asset_path('images/edging.jpg'),
              'title' => 'Edging',
              'link'  => get_permalink(get_page_by_path('capability/edging'))
            ],
            [
              'img'   => App\asset_path('images/etching.jpg'),
              'title' => 'Etching',
              'link'  => get_permalink(get_page_by_path('capability/etching'))
            ],
            [
              'img'   => App\asset_path('images/design.jpg'),
              'title' => 'Design',
              'link'  => get_permalink(get_page_by_path('capability/design'))
            ],
            [
              'img'   => App\asset_path('images/glass-pattern.jpg'),
              'title' => 'Glass Patterns',
              'link'  => get_permalink(get_page_by_path('options/glass-patterns'))
            ],
            [
              'img'   => App\asset_path('images/mirror-color.jpg'),
              'title' => 'Mirror Colors',
              'link'  => get_permalink(get_page_by_path('options/mirror-colors'))
            ],
          ]
        ])
      </div>
    </div>
  </section>

  {{-- We're not like the other guys --}}
  <section class="background-frosty-green">
    <div class="container">
      <div class="row">
        <div class="col s12 m6">
          <h2 class="offer-statement">We’re not like the other guys</h2>
          <p class="size-medium">See for yourself why we’re North Carolina’s premier custom glass and mirror fabricator! We offer:</p>
        </div>
      </div>
      <div class="row flex-grid">
        @include('partials.card-panel', [
          'cards'     => [
            [
              'class' => 'craftsmanship',
              'img'   => 'drill',
              'title' => 'Quality<br />Craftsmanship',
              'text'  => 'We enjoy an enduring reputation for superior quality craftsmanship and our highly experienced employees possess decades of industry experience.',
              'link'  => get_permalink(get_page_by_path('about/design-center')),
            ],
            [
              'class' => 'manufacturing',
              'img'   => 'leaf',
              'title' => 'Eco-Friendly<br />Manufacturing',
              'text'  => 'We take seriously our responsibility to protect the environment, our employees, customers, and others who may be impacted by our business.',
              'link'  => get_permalink(get_page_by_path('about/environment')),
            ],
            [
              'class' => 'pricing',
              'img'   => 'tag',
              'title' => 'Transparent<br />Pricing',
              'text'  => 'Transparency is all around us at Clearlight, from the glass we work with to our simple practice of sharing information in an open and honest manner.',
              'link'  => get_permalink(get_page_by_path('about/pricing-pledge')),
            ],
            [
              'class' => 'charitable',
              'img'   => 'charitable',
              'title' => 'Charitable<br />Projects',
              'text'  => 'We are proud of to offer charitable projects to give back to North Carolina’s communities.',
              'link'  => get_permalink(get_page_by_path('about/charitable-projects')),
            ],
          ]
        ])
        </div>
      </div>
    </div>
  </section>

  {{-- Inspiration --}}
  <section class="background-inspiration">
    <div class="container">
      <div class="row">
        <div class="col s12 m6 l5">
          <div class="z-depth-5 background-frosted">
            <a href="{{ get_post_type_archive_link('gallery') }}" class="mega-link" aria-hidden="true"></a>
            <h2>Need some inspiration?</h2>
            <p>Explore the endless possibilies of custom glass and mirror fabrication.</p>
            <p><a href="{{ get_post_type_archive_link('gallery') }}" class="link">Check out our galleries &rsaquo;</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="background-frosty-to-white">
    <div class="container">
      <div class="row flex-grid">
        <div class="col s12 m6 l5">
          <h2>Our customers love us, and you will too.</h2>
          <p class="size-medium">"The crew at Clearlight Glass and Mirror is extremely service oriented. I use them for all my projects and their communication and follow-through are unsurpassed."</p>
          <p><em>-5 Star Review on Houzz, March 2018</em></p>
        </div>
        <div class="col s12 m5 l4 offset-l1 valign-wrapper">
          <div>
            <p><a class="btn btn-dark btn-large" href="/about/testimonials/">Read more reviews</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
