@php
   $user = auth()->user();
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
      <meta http-equiv="X-UA-Compatible" content="ie=edge"/>  
      <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
      <link rel="stylesheet" href="https://unpkg.com/@tabler/core@latest/dist/css/tabler.min.css">
      <script src="https://js.stripe.com/v3/"></script>
   </head>
   <body>
   @include('sweetalert::alert', ['cdn' => "//cdn.jsdelivr.net/npm/sweetalert2@9"])
   <div class="wrapper">
      <header class="navbar navbar-expand-md navbar-light d-print-none">
         <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
               <a href="{{ route('dashboard') }}">
                  <x-application-logo height="40"/>
               </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
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
                     <span class="avatar avatar-sm" style="background-image: url({{$user->getFirstMediaUrl('profile') ? $user->getFirstMediaUrl('profile') : 'https://www.sevor.com.br/wp-content/uploads/elementor/thumbs/LOGO-SEVOR-ooprl9vkige2les3iup6j2dhfrnspoknxh6d0gx6o0.png'}})"></span>
                     <div class="d-none d-xl-block ps-2">
                        <div>{{ $user->name }}</div>
                        <div class="mt-1 small text-muted">{{ $user->roles->first()->name }}</div>
                     </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                     <a href="{{ route('profile.index')}}" class="dropdown-item">Meu perfil</a>
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
                     <x-breadcrumb></x-breadcrumb>
                  </div>
               </div>
               <div class="row align-items-center">
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