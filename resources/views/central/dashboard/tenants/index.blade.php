@section('title', trans('system.tenants'))
<x-app-layout>
    <x-slot name="title">
       {{ trans('system.tenants') }}
    </x-slot>
    <x-slot name="btns">
      <div class="btn-list">
        <a href="{{ route('dashboard') }}" class="btn btn-white">
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
                  <h3 class="card-title">{{ trans('system.tenants') }}</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                          <thead>
                            <tr>
                              <th class="w-50">{{ trans('system.tenant.name') }}</th>
                              <th>{{ trans('system.domain') }}</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                              @forelse ($tenants as $tenant)
                              <tr>
                                <td>{{ $tenant->name }}</td>
                                <td><a href="http://{{ $tenant->domains->first()->domain }}">{{ $tenant->domains->first()->domain }}</a></td>
                                <td class="text-end">
                                  <span class="dropdown">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">{{ trans('system.actions') }}</button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                       <a class="dropdown-item" href="{{route('tenants.impersonate', $tenant->id)}}">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                             <circle cx="8" cy="15" r="4"></circle>
                                             <line x1="10.85" y1="12.15" x2="19" y2="4"></line>
                                             <line x1="18" y1="5" x2="20" y2="7"></line>
                                             <line x1="15" y1="8" x2="17" y2="10"></line>
                                          </svg>
                                          {{ trans('system.impersonate') }}
                                       </a>
                                      <a class="dropdown-item" href="{{route('tenants.edit', $tenant->id)}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                            <line x1="16" y1="5" x2="19" y2="8"></line>
                                        </svg>
                                        {{ trans('system.edit') }}
                                      </a>
                                      <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-danger" data-bs-id="{{$tenant->id}}">
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
                                 <td colspan="2">
                                    <p class="text-center mt-2">{{ trans('system.nothing_found') }}</p>
                                 </td>
                              @endforelse
                          </tbody>
                        </table>
                      </div>
                </div>
                <div class="card-footer d-flex align-items-center">
                  <p class="m-0 text-muted">{{ trans('system.viewing') }} <span>{{ $tenants->firstItem() }}</span> - <span>{{ $tenants->lastItem() }}</span> de <span>{{ $tenants->total() }}</span> {{ trans('system.entries') }}</p>
                  {{ $tenants->links() }}
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" tenant="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" tenant="document">
          <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
              <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
              <h3>{{ trans('system.delete_sure') }}</h3>
              <div class="text-muted">{{ trans('system.alert_delete') }}</div>
            </div>
            <div class="modal-footer">
              <div class="w-100">
                <div class="row">
                  <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                      {{ trans('system.cancel') }}
                    </a></div>
                  <div class="col">
                    <form method="POST" id="delete" action="">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger w-100">
                            {{ trans('system.delete_permanent') }}
                          </button>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @push('scripts')
 <script>
  var exampleModal = document.getElementById('modal-danger')
   exampleModal.addEventListener('show.bs.modal', function (event) {
     // Button that triggered the modal
     var button = event.relatedTarget
     // Extract info from data-bs-* attributes
     var id = button.getAttribute('data-bs-id')

     // If necessary, you could initiate an AJAX request here
     // and then do the updating in a callback.
     //
     // Update the modal's content.
     var modalTitle = exampleModal.querySelector('#delete').setAttribute("action", "{{url()->current()}}/"+id)

   })

</script>
@endpush
</x-app-layout>