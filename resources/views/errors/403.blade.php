@section('title', __('Forbidden'))
<x-app-layout>
    <x-slot name="title">
        {{__('Forbidden')}}
    </x-slot>
    <x-slot name="btns">
       
    </x-slot>
    <div class="container-tight py-4">
        <div class="empty">
          <div class="empty-header">403</div>
          <p class="empty-title">Ops… Você acabou de encontrar uma página de erro</p>
          <p class="empty-subtitle text-muted">
            O usuário não tem as permissões corretas para acessar esta página.
          </p>
          <div class="empty-action">
            <a href="{{route('dashboard')}}" class="btn btn-primary">
              <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="5" y1="12" x2="19" y2="12"></line><line x1="5" y1="12" x2="11" y2="18"></line><line x1="5" y1="12" x2="11" y2="6"></line></svg>
              Voltar para a página inicial
            </a>
          </div>
        </div>
      </div>
 </x-app-layout>