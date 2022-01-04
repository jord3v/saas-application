<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
       <div class="navbar navbar-light">
          <div class="container-xl">
             <ul class="navbar-nav">
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                   <a class="nav-link" href="{{ route('dashboard') }}">
                      <span class="nav-link-icon d-md-none d-lg-inline-block">
                         <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <polyline points="5 12 3 12 12 3 21 12 19 12" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                         </svg>
                      </span>
                      <span class="nav-link-title">
                        {{ trans('system.dashboard') }}
                      </span>
                   </a>
                </li>
             </ul>
             <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0">
                <ul class="navbar-nav">
                   <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                         <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                               <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                         </span>
                         <span class="nav-link-title">
                         Configurações
                         </span>
                      </a>
                      <div class="dropdown-menu">
                         <a class="dropdown-item" href="{{route('settings.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-desktop" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <rect x="3" y="4" width="18" height="12" rx="1"></rect>
                                <line x1="7" y1="20" x2="17" y2="20"></line>
                                <line x1="9" y1="16" x2="9" y2="20"></line>
                                <line x1="15" y1="16" x2="15" y2="20"></line>
                             </svg>
                             Sistema
                         </a>
                         <a class="dropdown-item" href="{{route('roles.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-adjustments-horizontal" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <circle cx="14" cy="6" r="2"></circle>
                               <line x1="4" y1="6" x2="12" y2="6"></line>
                               <line x1="16" y1="6" x2="20" y2="6"></line>
                               <circle cx="8" cy="12" r="2"></circle>
                               <line x1="4" y1="12" x2="6" y2="12"></line>
                               <line x1="10" y1="12" x2="20" y2="12"></line>
                               <circle cx="17" cy="18" r="2"></circle>
                               <line x1="4" y1="18" x2="15" y2="18"></line>
                               <line x1="19" y1="18" x2="20" y2="18"></line>
                            </svg>
                            Controle de acesso
                         </a>
                         <a class="dropdown-item" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <circle cx="9" cy="7" r="4"></circle>
                               <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                               <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                               <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                            </svg>
                            Usuários do sistema
                         </a>
                         <a class="dropdown-item" href="{{route('subscriptions.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wallet" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"></path>
                               <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                            </svg>
                            Assinatura e pagamentos
                         </a>
                      </div>
                   </li>
                </ul>
             </div>
          </div>
       </div>
    </div>
 </div>