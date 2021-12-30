<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
      <meta http-equiv="X-UA-Compatible" content="ie=edge"/>  
      <title>{{ config('app.name', 'Laravel') }}</title>
      <link rel="stylesheet" href="https://unpkg.com/@tabler/core@latest/dist/css/tabler.min.css">
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