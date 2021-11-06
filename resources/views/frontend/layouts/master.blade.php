<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Payra Soft</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="description"
    content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <link rel="stylesheet" href="{{ Config::get('app.url').'public' }}{{mix('css/backend_app.css')}}">
  <link rel="stylesheet" href="{{ Config::get('app.url').'public/css/frontend_style.css' }}">

  @include('frontend.layouts.js_variable')

</head>

<body>
  <div class="container-fluid" id="app_frontend"></div>
  <script src="{{ Config::get('app.url').'public' }}{{mix('js/frontend_app.js')}}"></script>
</body>

</html>
