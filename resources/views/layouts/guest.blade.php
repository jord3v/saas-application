<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://unpkg.com/@tabler/core@latest/dist/css/tabler.min.css">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Stripe JS -->
   </head>
   <body>
    <div class="page page-center">
        <div class="container-tight py-4">
          <div class="text-center mb-4">
            <a href="/" class="navbar-brand navbar-brand-autodark">
                <x-application-logo height="72"/>
            </a>
          </div>
          {{ $slot }}
        </div>
      </div>
   <script src="https://unpkg.com/@tabler/core@latest/dist/js/tabler.min.js"></script>
   </body>
</html>