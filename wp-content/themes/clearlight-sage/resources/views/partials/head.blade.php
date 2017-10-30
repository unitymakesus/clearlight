<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @if (!is_user_logged_in())
    @include('partials.tag-manager-head')
  @endif
  @php(wp_head())
</head>
