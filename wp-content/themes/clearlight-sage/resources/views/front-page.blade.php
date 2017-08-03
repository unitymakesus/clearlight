@extends('layouts.app')

@section('content')

  {{-- Hero --}}
  <section class="hero">
    <div class="background-video">
      <video class="" id="video-blur" playsinline mute loop preload="auto">
        <source src="{{ App\asset_path('images/ClearLight-v4-Final-blur.mp4') }}" type="video/mp4" />
      </video>
    </div>
    <div class="background-video sharp">
      <video class="" id="video-sharp" playsinline mute loop preload="auto">
        <source src="{{ App\asset_path('images/ClearLight-v4-Final.mp4') }}" type="video/mp4" />
      </video>
    </div>

    <div class="hero-text">
      <div class="container">
        <div class="row">
          <div class="col s12 m7 l6">
            <h1>Looking for custom glass or mirror products?</h1>
            <p>Serving the community for nearly 25 years, we are North Carolina's premier custom glass and mirror fabricator and can make the perfect piece for your project.</p>
            <a class="btn-large" href="#">What can we do for you?</a>
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
              'img'   => App\asset_path('images/product-thumb1.jpg'),
              'title' => 'Custom Shapes',
              'link'  => '#'
            ],
            [
              'img'   => App\asset_path('images/product-thumb2.jpg'),
              'title' => 'Edging',
              'link'  => '#'
            ],
            [
              'img'   => App\asset_path('images/product-thumb3.jpg'),
              'title' => 'Etching',
              'link'  => '#'
            ],
            [
              'img'   => App\asset_path('images/product-thumb4.jpg'),
              'title' => 'Design',
              'link'  => '#'
            ],
            [
              'img'   => App\asset_path('images/product-thumb5.jpg'),
              'title' => 'Glass Patterns',
              'link'  => '#'
            ],
            [
              'img'   => App\asset_path('images/product-thumb6.jpg'),
              'title' => 'Mirror Colors',
              'link'  => '#'
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
        <div class="col s12 m6 l3">
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
              'link'  => '#',
            ],
            [
              'class' => 'manufacturing',
              'img'   => App\asset_path('images/leaf.svg'),
              'title' => 'Eco Friendly<br />Manufacturing',
              'text'  => 'We take seriously our responsibility to protect the environment, our employees, customers, and others who may be impacted by our business.',
              'link'  => '#',
            ],
            [
              'class' => 'pricing',
              'img'   => App\asset_path('images/tag.svg'),
              'title' => 'Transparent<br />Pricing',
              'text'  => 'Transparency is all around us at Clearlight, from the glass we work with to our simple practice of sharing information in an open and honest manner.',
              'link'  => '#',
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
            <h2>Need some inspiration?</h2>
            <p>Explore the endless possibilies of custom glass and mirror fabrication.</p>
            <p><a href="#">Check out our Gallery &rsaquo;</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
