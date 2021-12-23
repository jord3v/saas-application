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
      <script src="https://js.stripe.com/v3/"></script>
   </head>
   <body>
   <div class="wrapper">
      <header class="navbar navbar-expand-md navbar-light d-print-none">
         <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
               <a href="{{ route('dashboard') }}">
               <img src="https://preview.tabler.io/static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
               </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
               <div class="nav-item d-none d-md-flex me-3">
                  <div class="btn-list">
                     <a href="{{ route('subscriptions.index')}}" class="btn {{ request()->is('c') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wallet" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"></path>
                            <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                        </svg>
                        Assinaturas
                     </a>
                  </div>
               </div>
               <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                  <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                  </svg>
               </a>
               <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                  <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <circle cx="12" cy="12" r="4" />
                     <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                  </svg>
               </a>
               <div class="nav-item dropdown d-none d-md-flex me-3">
                  <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                     <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                     </svg>
                     <span class="badge bg-red"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                     <div class="card">
                        <div class="card-body">
                           Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                        </div>
                     </div>
                  </div>
               </div>
               <div class="nav-item dropdown">
                  <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                     <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                     <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                     </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                     <a href="#" class="dropdown-item">Meu perfil</a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </header>
      @include('layouts.navigation')
      <div class="page-wrapper">
         <div class="container-xl">
            <div class="page-header d-print-none">
               <div class="row align-items-center">
                  <div class="col">
                     <h2 class="page-title">
                        {{ $title }}
                     </h2>
                  </div>
                  <div class="col-auto ms-auto d-print-none">
                     {{ $btns }}
                  </div>
               </div>
            </div>
         </div>
         <div class="page-body">
            {{ $slot }}
         </div>
         <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
               <div class="row text-center align-items-center flex-row-reverse">
                  <div class="col-lg-auto ms-lg-auto">
                     <ul class="list-inline list-inline-dots mb-0">
                        <li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a></li>
                     </ul>
                  </div>
                  <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                     <ul class="list-inline list-inline-dots mb-0">
                        <li class="list-inline-item">
                           Copyright &copy; 2021
                           <a href="." class="link-secondary">Tabler</a>.
                           All rights reserved.
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </footer>
      </div>
   </div>
   <script src="https://unpkg.com/@tabler/core@latest/dist/js/tabler.min.js"></script>
   </body>
</html>
{{--<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Fonts -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
      <!-- Styles -->
      <link rel="stylesheet" href="{{ global_asset('css/app.css') }}">
      <!-- Scripts -->
      <script src="{{ global_asset('js/app.js') }}" defer></script>
      <!-- Lib do Stripe -->
      <script src="https://js.stripe.com/v3/"></script>
   </head>
   <body class="font-sans antialiased">
      <div class="min-h-screen bg-gray-100">
         @include('layouts.navigation')
         <!-- Page Heading -->
         <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
               {{ $header }}
            </div>
         </header>
         <!-- Page Content -->
         <main>
            {{ $slot }}
         </main>
      </div>
   </body>
</html>
--}}