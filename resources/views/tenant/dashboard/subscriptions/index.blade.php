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
            <a href="{{ route('subscriptions.checkout')}}" class="btn btn-primary">Assinar</a>
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
                  <th>Status</th>
                  <th>Valor</th>
                  <th>Data de criação</th>
                  <th>Data de vencimento</th>
                  <th class="text-end"></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($billings as $billing)
                <tr>
                  <td>
                    @if ($billing->status == 'succeeded')
                      <span class="badge bg-success me-1"></span> Pago
                    @else
                      <span class="badge bg-warning me-1"></span> Pendente  
                    @endif
                  </td>
                  <td><span>R$ {{$billing->amount/100}}</span></td>
                  @if ($billing->next_action)
                    <td><span>{{date('d/m/Y', $billing->created)}}</span></td>
                    <td><span>{{date('d/m/Y', $billing->next_action->boleto_display_details->expires_at)}}</span></td>
                  @else
                    <td>{{date('d/m/Y', $billing->created)}}</td>
                    <td>-</td>
                  @endif
                  
                  
                  <td class="text-end">
                    @if ($billing->next_action)
                      <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-report" data-bs-number="{{$billing->next_action->boleto_display_details->number}}" data-bs-pdf="{{$billing->next_action->boleto_display_details->pdf}}" data-bs-expires_at="{{date('d/m/Y', $billing->next_action->boleto_display_details->expires_at)}}">
                        Efetuar pagamento
                      </a>
                    @else
                      <a href="{{$billing->charges->data[0]->receipt_url}}" class="btn" target="_target">Baixar comprovante</a>    
                    @endif
                    
                  </td>
                </tr>    
                @empty
                <tr>
                  <td colspan="5">
                    <p class="text-center mt-2">nada encontrado</p>
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
  <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Efetuar pagamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info" role="alert">
            O prazo de compensação de pagamento de boletos bancários é de até 72 horas úteis.
          </div>
          <div class="mb-3">
            <label class="form-label">Copiar o código de barra</label>
            <h3></h3>
          </div>
          <p>Data de vencimento <span class="expire_at"></span></p>
          <div class="col-6 col-sm-4 col-md-6 col-xl mb-3">
            <a href="#" class="btn btn-primary w-100" id="pdf" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                <line x1="12" y1="11" x2="12" y2="17"></line>
                <polyline points="9 14 12 17 15 14"></polyline>
             </svg>
              Fazer o download do boleto
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Fechar
          </a>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
<script>
    var modal = document.getElementById('modal-report')
    modal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    var number = button.getAttribute('data-bs-number')
    var pdf = button.getAttribute('data-bs-pdf')
    var expires_at = button.getAttribute('data-bs-expires_at')

    var modalTitle = modal.querySelector('.modal-title')
    modal.querySelector('.modal-body .expire_at').innerHTML = expires_at;
    modal.querySelector('.modal-body h3').innerHTML = number;
    modal.querySelector('#pdf').setAttribute("href", pdf);
})

</script>