@section('title', trans('system.add_role'))
<x-app-layout>
   <x-slot name="title">
      {{ trans('system.add_role') }}
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
            <form role="form" action="{{ route('roles.update',$role->id) }}" method="post" enctype="multipart/form-data">
               @csrf
               @method('PUT')
               <div class="card mb-3">
                  <div class="card-header">
                     <h3 class="card-title">{{ trans('system.role_details') }}</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6 col-xl-12">
                           <div class="mb-3">
                              <div class="row g-2">
                                 <div class="col-12 col-md-12">
                                    <label class="form-label">{{__('Name')}}</label>
                                    <input type="text" class="form-control" name="name" value="{{$role->name ?? old('name')}}" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6 col-xl-12">
                           <div class="mb-3">
                              <label class="form-label">{{ trans('system.permissions') }}</label>
                              <div class="row g-2">
                                 @foreach($permissions->groupBy('type') as $key => $permission)
                                 <div class="col-3">
                                    <label class="form-label">{{ trans('system.'.$key) }}</label>
                                    @foreach ($permission as $item)
                                    <label class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permission[]" value="{{$item->id}}" {{ $role->permissions->contains($item->id) ? 'checked' : '' }}>
                                    <span class="form-check-label">
                                    {{ trans('system.'.$item->name) }}
                                    </span>
                                    </label>
                                    @endforeach
                                 </div>
                                 @endforeach
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