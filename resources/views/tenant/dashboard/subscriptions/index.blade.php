<x-app-layout>
  <x-slot name="title">
     {{ __('Assinaturas') }}
  </x-slot>
  <x-slot name="btns">
    <div class="btn-list">
      <span class="d-none d-sm-inline">
        @if($subscription)
          @if ($subscription->cancelled() && $subscription->onGracePeriod())
            <a href="{{ route('subscriptions.resume')}}" class="btn btn-green">Reativar Assinatura</a>
            <br>
            Seu acesso vai até: {{$tenant->access_end}}
          @elseif(!$subscription->cancelled())
            <a href="{{ route('subscriptions.cancel')}}" class="btn btn-danger">Cancelar Assinatura</a>
          @endif
          @if ($subscription->ended())
              Assinatura cancelada
          @endif
        @else
          não é assinante
        @endif
      </span>
    </div>
 </x-slot>
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              Detalhes
            </h3>
            <div class="card-actions">
              <a href="#">
                Edit configuration<!-- Download SVG icon from http://tabler-icons.io/i/edit -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path><line x1="16" y1="5" x2="19" y2="8"></line></svg>
              </a>
            </div>
          </div>
          <div class="card-body">
            <dl class="row">
              <dt class="col-5">Plano atual:</dt>
              <dd class="col-7">{{$subscription ? $subscription : 'Degustação 7 dias grátis'}}</dd>
              <dt class="col-5">Account:</dt>
              <dd class="col-7">tabler</dd>
              <dt class="col-5">Location:</dt>
              <dd class="col-7"><span class="flag flag-country-pl"></span>
                Poland</dd>
              <dt class="col-5">IP Address:</dt>
              <dd class="col-7">46.113.11.3</dd>
              <dt class="col-5">Operating system:</dt>
              <dd class="col-7">OS X 10.15.2 64-bit</dd>
              <dt class="col-5">Browser:</dt>
              <dd class="col-7">Chrome</dd>
            </dl>
          </div>
        </div>
      </div>
      <div class="col-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Histórico de faturamento</h3>
          </div>
          <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
              <thead>
                <tr>
                  <th>Data de pagamento</th>
                  <th>Valor pago</th>
                  <th class="text-end">Fatura e Recibo</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($invoices as $invoice)
                <tr>
                  <td>{{$invoice->date()->format('d/m/y \a\s H:i')}}</td>
                  <td><span class="text-muted">{{$invoice->total()}}</span></td>
                  <td class="text-end">
                    <a href="{{$invoice->hosted_invoice_url}}" class="btn" target="_target">Baixar</a>
                  </td>
                </tr>    
                @empty
                <tr>
                  <td colspan="3">
                    <p class="text-center">nada encontrado</p>
                  </td>
                </tr>                    
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>