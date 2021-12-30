<x-app-layout>
    <x-slot name="title">
       {{ __('Página inicial') }}
    </x-slot>
    <x-slot name="btns">
       <div class="btn-list">
          
       </div>
    </x-slot>
    <div class="container-xl d-flex flex-column justify-content-center">
       <div class="empty">
          <p class="empty-title">Seja bem vindo</p>
          <p class="empty-subtitle text-muted">
             Painel administrativo em construção
          </p>
       </div>
    </div>
 </x-app-layout>