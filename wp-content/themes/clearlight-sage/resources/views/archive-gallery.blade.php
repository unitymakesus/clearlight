@extends('layouts.app')

@section('content')
  <div class="page-header" style="background-image: url('{{ get_the_post_thumbnail_url(get_the_id(), 'featured-banner') }}')">
    <div class="container">
      <div class="row">
        <div class="col s12 m9 l6">
          <h1>Explore the possibilities of custom glass and mirrors</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="background-white">
    <div class="container">
      <div class="row block-grid up-s2 up-m4 up-l4">
        @while (have_posts()) @php(the_post())
          @php
            $img = get_field('primary_thumbnail');
          @endphp

          @include('partials.card-image', [
            'cards'     => [
              [
                'img'   => $img['sizes']['thumbnail2x'],
                'title' => get_the_title(),
                'link'  => get_permalink()
              ],
            ]
          ])
        @endwhile
      </div>
    </div>
  </div>

@endsection
