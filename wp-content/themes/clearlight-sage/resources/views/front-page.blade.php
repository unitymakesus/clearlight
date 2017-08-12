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
          <div class="col s12 m9 l6">
            <h1>Looking for custom glass or mirror products?</h1>
            <p>Serving the community for nearly 25 years, we are North Carolina's premier custom glass and mirror fabricator and can make the perfect piece for your project.</p>
            <a class="btn-large" href="{{ get_permalink(get_page_by_path('request-a-quote')) }}">What can we do for you?</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Customization tiles --}}
  <section class="background-white">
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
      <div class="row flex-grid">
        <div class="col s12 m8 l3">
          <h2 class="offer-statement">We’re not like the other guys</h2>
          <p class="size-medium">See for yourself why we’re North Carolina’s premier custom glass and mirror fabricator! We offer:</p>
        </div>

        @include('partials.card-panel', [
          'cards'     => [
            [
              'class' => 'craftsmanship',
              'img'   => App\asset_path('images/drill.svg'),
              'title' => 'Quality<br />Craftsmanship',
              'text'  => 'We enjoy an enduring reputation for superior quality craftsmanship and our highly experienced employees possess decades of industry experience.',
              'link'  => get_permalink(get_page_by_path('about/design-center')),
            ],
            [
              'class' => 'manufacturing',
              'img'   => App\asset_path('images/leaf.svg'),
              'title' => 'Eco Friendly<br />Manufacturing',
              'text'  => 'We take seriously our responsibility to protect the environment, our employees, customers, and others who may be impacted by our business.',
              'link'  => get_permalink(get_page_by_path('about/environment')),
            ],
            [
              'class' => 'pricing',
              'img'   => App\asset_path('images/tag.svg'),
              'title' => 'Transparent<br />Pricing',
              'text'  => 'Transparency is all around us at Clearlight, from the glass we work with to our simple practice of sharing information in an open and honest manner.',
              'link'  => get_permalink(get_page_by_path('about/our-promise')),
            ],
          ]
        ])

      </div>
    </div>
  </section>

  {{-- Inspiration --}}
  <section class="background-inspiration">
    <div class="container">
      <div class="row">
        <div class="col s12 m6 l5">
          <div class="z-depth-4 background-frosted">
            <a href="{{ get_permalink(get_page_by_path('galleries')) }}" class="mega-link" aria-hidden="true"></a>
            <h2>Need some inspiration?</h2>
            <p>Explore the endless possibilies of custom glass and mirror fabrication.</p>
            <p><a href="{{ get_permalink(get_page_by_path('galleries')) }}" class="link">Check out our galleries &rsaquo;</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
