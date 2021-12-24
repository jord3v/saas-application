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
      <div class="col-12">
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
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($invoices as $invoice)
                <tr>
                  <td>{{$invoice->date()->toFormattedDateString()}}</td>
                  <td><span class="text-muted">{{$invoice->total()}}</span></td>
                  <td class="text-end">
                    <a href="{{route('subscriptions.invoice.download', $invoice->id)}}" class="btn">Baixar</a>
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