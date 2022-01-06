@section('title', trans('system.profile'))
<x-app-layout>
   <x-slot name="title">
      {{ trans('system.profile') }}
   </x-slot>
   <x-slot name="btns">
      <div class="btn-list">
         <a href="./" class="btn btn-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
               <line x1="5" y1="12" x2="19" y2="12"></line>
               <line x1="5" y1="12" x2="11" y2="18"></line>
               <line x1="5" y1="12" x2="11" y2="6"></line>
            </svg>
            {{ trans('system.back') }}
         </a>
      </div>
   </x-slot>
   <div class="container-xl">
      <div class="row row-cards">
         <div class="col-12">
            <form class="needs-validation" role="form" action="" method="post" enctype="multipart/form-data" novalidate>
               @csrf
               <div class="card mb-3">
                  <div class="card-header">
                     <h3 class="card-title">{{ trans('system.personal_data') }}</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6 col-xl-12">
                           <div class="mb-3">
                              <div class="row g-2">
                                 <div class="col-12 col-md-4">
                                    <label class="form-label">{{__('Name')}}</label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}" required>
                                 </div>
                                 <div class="col-12 col-md-3">
                                    <label class="form-label">{{__('Email')}}</label>
                                    <input type="text" class="form-control" name="email" value="{{$user->email}}" required>
                                 </div>
                                 <div class="col-5 col-md-2">
                                    <label class="form-label">{{__('Password')}}</label>
                                    <input type="password" class="form-control" name="password" value="">
                                 </div>
                                 <div class="col-5 col-md-2">
                                    <label class="form-label">{{__('Confirm Password')}}</label>
                                    <input type="password" class="form-control" name="confirm-password" value="">
                                 </div>
                                 <div class="col-2 col-md-1">
                                    <label class="form-label">Google <span class="form-help" data-bs-toggle="popover" data-bs-placement="top"
                                       data-bs-content="<p>{{$user->google_id ? trans('system.google.link_success') : trans('system.google.revoke_success')}}</p>
                                       <p class='mb-0'>@if($user->google_id) <a href='{{route('google.revoke')}}'>{{trans('system.google.revoke')}}</a> @else  <a href='{{route('google.link')}}'>{{trans('system.google.link')}}</a> @endif</p>
                                       "
                                       data-bs-html="true">?</span></label>
                                    <a href="javascript:void(0)" class="btn {{!$user->google_id ? 'disabled': ''}}">
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
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-end">
                     <div class="d-flex">
                        <button type="submit" class="btn btn-primary ms-auto">{{ trans('system.save') }}</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</x-app-layout>