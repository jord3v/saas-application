@section('title', trans('system.roles'))
<x-app-layout>
    <x-slot name="title">
       {{ trans('system.roles') }}
    </x-slot>
    <x-slot name="btns">
      <div class="btn-list">
        <a href="{{ route('subscriptions.index') }}" class="btn btn-white">
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
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">{{ trans('system.user_profiles') }}</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                          <thead>
                            <tr>
                              <th class="w-50">{{__('Name')}}</th>
                              <th>{{ trans('system.permissions') }}</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                              @forelse ($roles as $role)
                              <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->permissions->count() }}</td>
                                <td class="text-end">
                                  <span class="dropdown">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">{{ trans('system.actions') }}</button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                      <a class="dropdown-item" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                            <line x1="16" y1="5" x2="19" y2="8"></line>
                                        </svg>
                                        {{ trans('system.edit') }}
                                      </a>
                                      <a class="dropdown-item" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="4" y1="7" x2="20" y2="7"></line>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                         </svg>
                                        {{ trans('system.delete') }}
                                      </a>
                                    </div>
                                  </span>
                                </td>
                              </tr>      
                              @empty
                                  
                              @endforelse
                            
                          </tbody>
                        </table>
                      </div>
                </div>
                <div class="card-footer d-flex align-items-center">
                  <p class="m-0 text-muted">{{ trans('system.viewing') }} <span>{{ $roles->firstItem() }}</span> - <span>{{ $roles->lastItem() }}</span> de <span>{{ $roles->total() }}</span> {{ trans('system.entries') }}</p>
                  {{ $roles->links() }}
                </div>
              </div>
          </div>
        </div>
      </div>
 </x-app-layout>