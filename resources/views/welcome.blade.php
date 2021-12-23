<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://unpkg.com/@tabler/core@latest/dist/css/tabler.min.css">
      <title>{{ config('app.name', 'Laravel') }}</title>
   </head>
   <body>
      <div class="page page-center">
         <div class="container-tight">
            <div class="text-center mb-1">
               <a href="." class="navbar-brand navbar-brand-autodark"><img src="https://preview.tabler.io/static/logo.svg" height="36" alt=""></a>
            </div>
            <form action="{{ route('website.store') }}" method="post" id="form">
               @csrf
               <div class="card card-md">
                  <input type="hidden" name="token" value="{{str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')}}">
                  <div class="card-body text-center">
                     <h1 class="mt-5">Crie sua conta</h1>
                  </div>
                  <div class="hr-text hr-text-center hr-text-spaceless">Dados pessoais</div>
                  <div class="card-body">
                     <div class="input-icon mb-2">
                        <span class="input-icon-addon">
                           <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <circle cx="12" cy="12" r="9"></circle>
                              <circle cx="12" cy="10" r="3"></circle>
                              <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"></path>
                           </svg>
                        </span>
                        <input type="text" class="form-control" name="manager" placeholder="Nome completo" required>
                     </div>
                     <div class="input-icon mb-2">
                        <span class="input-icon-addon">
                           <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                              <polyline points="3 7 12 13 21 7"></polyline>
                           </svg>
                        </span>
                        <input type="email" class="form-control" name="email" placeholder="Endereço de e-mail" required>
                     </div>
                     <div class="input-icon mb-2">
                        <span class="input-icon-addon">
                           <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                              <circle cx="12" cy="16" r="1"></circle>
                              <path d="M8 11v-4a4 4 0 0 1 8 0v4"></path>
                           </svg>
                        </span>
                        <input type="password" class="form-control" name="password" placeholder="Crie uma senha segura" required>
                     </div>
                  </div>
                  <div class="hr-text hr-text-center hr-text-spaceless">Dados da organização</div>
                  <div class="card-body">
                     <div class="input-icon mb-2">
                        <span class="input-icon-addon">
                           <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-skyscraper" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <line x1="3" y1="21" x2="21" y2="21"></line>
                              <path d="M5 21v-14l8 -4v18"></path>
                              <path d="M19 21v-10l-6 -4"></path>
                              <line x1="9" y1="9" x2="9" y2="9.01"></line>
                              <line x1="9" y1="12" x2="9" y2="12.01"></line>
                              <line x1="9" y1="15" x2="9" y2="15.01"></line>
                              <line x1="9" y1="18" x2="9" y2="18.01"></line>
                           </svg>
                        </span>
                        <input type="text" class="form-control" name="name" placeholder="Nome da organização" required>
                     </div>
                     <div class="input-icon mb-2">
                        <div class="input-group input-group-flat">
                           <span class="input-group-text">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                 <path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5"></path>
                                 <path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5"></path>
                              </svg>
                           </span>
                           <input type="text" class="form-control text-end pe-0" name="domain" pattern="^[a-zA-Z0-9\\-]+$" title="somente letras e números" placeholder="link-da-minha-organizacao" required>
                           <span class="input-group-text">
                           .localhost
                           </span>
                        </div>
                     </div>
                     <div class="form-footer">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 btn btn-primary w-100">
                        Criar conta
                        </button>
                     </div>
                  </div>
                  <div class="hr-text hr-text-center hr-text-spaceless">ou inscreva-se usando o</div>
                  <div class="card-body">
                     <a href="#" class="btn">
                        <!-- Download SVG icon from http://tabler-icons.io/i/brand-google -->
                        <svg viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                           <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                             <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"/>
                             <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"/>
                             <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"/>
                             <path fill="#EA4335" d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"/>
                           </g>
                        </svg>
                     </a>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <script src="https://unpkg.com/@tabler/core@latest/dist/js/tabler.min.js"></script>
   </body>
</html>