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
            <h3 class="card-title">Faturas</h3>
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
{{--<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minha assinatura') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(tenant()->subscription('default'))
                        @if(tenant()->subscription('default')->onGracePeriod())
                            <a href="{{ route('subscriptions.resume')}}" class="bg-red hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Reativar Assinatura</a>
                            <button type="button" class="focus:outline-none text-white text-sm py-2.5 px-5 rounded-md bg-blue-500 hover:bg-blue-600 hover:shadow-lg">Primary</button>

                        @else
                            <a href="{{ route('subscriptions.cancel')}}" class="bg-red hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Cancelar Assinatura</a>
                        @endif
                    @else 
                        não é assinante
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Data
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Preço
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Download
                            </th>
                          </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($invoices as $invoice)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                  <div class="text-sm text-gray-900">{{$invoice->date()->toFormattedDateString()}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{$invoice->total()}}
                                  </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                  <a href="{{route('subscriptions.invoice.download', $invoice->id)}}">Baixar</a>
                                </td>
                              </tr>
                            @empty
                                
                            @endforelse
                          <!-- More people... -->
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
--}}