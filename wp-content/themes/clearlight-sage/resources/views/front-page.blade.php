@extends('layouts.app')

@section('content')

  {{-- Hero --}}
  <div class="hero">
    <div class="looking">
      <h1>Looking for custom glass or mirror products?</h1>
      <p class="hero-text">Serving the community for nearly 25 years, we are North Carolina's premier custom glass and mirror fabricator and can make the perfect piece for your project.</p>
      <button class="hero-button">What can we do for you?</button>
    </div>
  </div>

  {{-- Customization tiles --}}
  <div class="custom">
    <div class="row">
      <div class="row s2 m3 l6">
        <a href="#" alt="Custom Shapes">
          <div class="card-panel custom-shapes">
          </div>
        </a>
        <a href="#" alt="Edging">
          <div class="card-panel edging">
          </div>
        </a>
        <a href="#" alt="Etching">
          <div class="card-panel etching">
          </div>
        </a>
        <a href="#" alt="Design">
          <div class="card-panel design">
          </div>
        </a>
        <a href="#" alt="Glass Patterns">
          <div class="card-panel glass-patterns">
          </div>
        </a>
        <a href="#" alt="Mirror Colors">
          <div class="card-panel mirror-colors">
          </div>
        </a>
      </div>
    </div>
  </div>

  {{-- We're not like the other guys --}}
  <div class="difference">
    <div class="tile-container">
      <div class="offer">
        <h2 class="offer-statement">We're not like the other guys</h2>
        <p>See for yourself why we’re North Carolina’s premier custom glass and mirror fabricator! We offer:</p>
      </div>
      <a href="#">
        <div class="craftsmanship">
          <img src="./images/drill.svg" alt="Power Drill Icon" class="small-icon">
          <h3>Quality Craftsmanship</h3>
          <span>We enjoy an enduring reputation for superior quality craftsmanship and our highly experienced employees possess decades of industry experience.</span>
          <a href="#" class="learn-more" alt="Learn More">Learn More</a>
        </div>
      </a>
      <a href="#">
        <div class="manufacturing">
          <img src="./images/leaf.svg" alt="Eco Friendly Icon" class="small-icon">
          <h3>Eco Friendly Manufacturing</h3>
          <span>We take seriously our responsibility to protect the environment, our employees, customers, and others who may be impacted by our business.</span>
          <a href="#" class="learn-more" alt="Learn More">Learn More</a>
        </div>
      </a>
      <a href="#">
        <div class="pricing">
          <img src="./images/tag.svg" alt="Price Tag Icon" class="small-icon">
          <h3>Transparent Pricing</h3>
          <span>Transparency is all around us at Clearlight, from the glass we work with to our simple practice of sharing information in an open and honest manner.</span>
          <a href="#" class="learn-more" alt="Learn More">Learn More</a>
        </div>
      </a>
    </div>
  </div>

  {{-- Inspiration --}}
  <div class="inspiration">
    <div class="background-image">
      <img src="./images/gallery.png" alt="Image Gallery">
    </div>
  </div>

  {{-- Getting Started --}}
  <div class="started">
    <div class= "info">
      <h2 class="get-started">Ready to get started?</h2>
      <p class="perfect-piece">Contact us today to discover how we can make the perfect piece for your project.</p>
    </div>
    <div class="request-quote">
      <button class="body-quote" href="#">Request a Quote</button>
    </div>
  </div>

@endsection
