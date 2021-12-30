@php
$_GET['payment'] = isset($_GET['payment']) ? $_GET['payment'] : 'cartao';
$options = array('', 'boleto', 'cartao', 'pix'); 
if (!in_array($_GET['payment'], $options)) { 
header('Location: '.route('dashboard'));
exit();
}
@endphp
<x-app-layout>
   <x-slot name="title">
      {{ __('Assinar') }}
   </x-slot>
   <x-slot name="btns">
      <div class="btn-list">
         <span class="d-none d-sm-inline">
            <a href="{{ route('subscriptions.index') }}" class="btn btn-white">
               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <line x1="5" y1="12" x2="11" y2="18"></line>
                  <line x1="5" y1="12" x2="11" y2="6"></line>
               </svg>
               Voltar
            </a>
         </span>
      </div>
   </x-slot>
   <div class="container-xl">
      <div class="row row-cards">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Selecione a forma de pagamento e o plano</h3>
               </div>
               <div class="card-body">
                  <form action="{{ route('subscriptions.store') }}" method="post" class="form" id="form">
                     @csrf
                     <div class="form-group mb-3">
                        <label class="form-label">Forma de pagamento</label>
                        <div>
                           <select class="form-select" name="method_payment" required onchange="window.location = this.options[this.selectedIndex].value">
                              <option value="">Selecione a forma de pagamento</option>
                              <option value="?payment=boleto" {{$_GET['payment'] == 'boleto' ? 'selected':''}}>Boleto bancário</option>
                              <option value="?payment=cartao" {{$_GET['payment'] == 'cartao' ? 'selected':''}}>Cartão de crédito</option>
                              <option value="?payment=pix" {{$_GET['payment'] == 'pix' ? 'selected':''}}>Pix</option>
                           </select>
                        </div>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Plano</label>
                        <div class="row">
                           @forelse ($plans as $plan)
                           <div class="col-sm-6 col-lg-3">
                              <div class="card card-md">
                                 <div class="card-body text-center">
                                    <div class="text-uppercase text-muted font-weight-medium">{{$plan->product->name}}</div>
                                    <div class="display-6 my-3">R$ {{$plan->unit_amount/100}}</div>
                                    <ul class="list-unstyled lh-lg">
                                       @forelse (collect($plan->product->metadata) as $key => $value)
                                       <li><strong>{{$value}}</strong> {{$key}}</li>
                                       @empty
                                       @endforelse
                                    </ul>
                                    <div class="text-center mt-4">
                                       <label class="btn w-100">
                                       <input type="radio" name="plan" value="{{$plan->id}}"> <span class="px-2">Escolher plano</span>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @empty
                           <div class="col">
                              nada encontrado 
                           </div>
                           @endforelse
                        </div>
                     </div>
                     <div class="py-3">
                        @if($_GET['payment'] == 'cartao')
                        <div class="cartao">
                           <div class="form-group mb-3">
                              <label class="form-label">Nome completo</label>
                              <div>
                                 <input type="text" class="form-control" id="card-holder-name" value="{{auth()->user()->name}}">
                                 <small class="form-hint">Não armazenamos dados relacionado a cartão de crédito em nosso banco de dados.</small>
                              </div>
                           </div>
                           <div class="form-group mb-3 ">
                              <div>
                                 <label class="form-label">Cartão de crédito</label>
                                 <div id="card-element"></div>
                              </div>
                           </div>
                        </div>
                        @endif
                        @if($_GET['payment'] == 'boleto')
                        <div class="boleto">
                           <div class="col-md-6 col-xl-12">
                              <div class="mb-3">
                                 <div class="row mb-3">
                                    <div class="col-12 col-md-6">                                  
                                       <label class="form-label">Responsável</label>
                                       <input type="text" class="form-control" value="{{$method->billing_details->name ?? ''}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-3">
                                       <label class="form-label">Endereço de e-mail</label>
                                       <input type="text" class="form-control" value="{{$method->billing_details->email ?? ''}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-3">
                                       <label class="form-label">CPF ou CNPJ</label>
                                       <input type="text" class="form-control" value="{{$method->boleto->tax_id ?? ''}}" readonly>
                                    </div>
                                 </div>
                              </div>
                              <div class="mb-3">
                                 <div class="row mb-3">
                                    <div class="col-12 col-md-2">                                  
                                       <label class="form-label">CEP</label>
                                       <input type="text" class="form-control" data-mask="00000-000" data-mask-visible="true" autocomplete="off" onblur="pesquisacep(this.value);" value="{{$method->billing_details->address->postal_code ?? ''}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-5">
                                       <label class="form-label">Logradouro</label>
                                       <input type="text" class="form-control" value="{{$method->billing_details->address->line1 ?? ''}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-4">
                                       <label class="form-label">Cidade</label>
                                       <input type="text" class="form-control" value="{{$method->billing_details->address->city ?? ''}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-1">
                                       <label class="form-label">Estado</label>
                                       <input type="text" class="form-control" value="{{$method->billing_details->address->state ?? ''}}" readonly>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endif
                        <div class="pix" style="display: none;">
                           pix
                        </div>
                     </div>
                     <div class="form-footer">
                        <strong id="show-errors" style="display: none;" class="text-danger py-2"></strong>
                        <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">Enviar</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>
<script>
   function selectCurSort() {
      var match = window.location.href.split('?')[1];
      $('#sort').find('option[value$="'+match+'"]').attr('selected',true);
   }
   selectCurSort();
   
   
   function val() {
      document.querySelector('.cartao').style.display = 'none';
      document.querySelector('.boleto').style.display = 'none';
      document.querySelector('.pix').style.display = 'none';
      mp = document.getElementById("method_payment").value;
      document.querySelector('.'+mp+'').style.display = '';           // Hide
      if(mp != 'cartao'){
          document.querySelector(".form").removeAttribute("id")
          document.querySelector('.cartao').remove()
          document.querySelector('#card-button').removeAttribute('id')
      }
   }
</script>
<script>
   const stripe = Stripe("{{ config('cashier.key') }}");
   const elements = stripe.elements();
   const cardElement = elements.create('card');
   cardElement.mount('#card-element');
   
   // subscription payment
   
   const form = document.getElementById('form')
   const cardHolderName = document.getElementById('card-holder-name')
   const cardButton = document.getElementById('card-button')
   const clientSecret = cardButton.dataset.secret
   const showErrors = document.getElementById('show-errors')
   
   
   form.addEventListener('submit', async (e) => {
       e.preventDefault()
       // Disable button
        cardButton.classList.add('disabled')
        cardButton.firstChild.data = 'Validando...'
        
        // reset errors
        showErrors.innerText = ''
        showErrors.style.display = 'none'
   
       const { setupIntent, error } = await stripe.confirmCardSetup(
           clientSecret, {
               payment_method: {
                   card: cardElement,
                   billing_details: {
                       name: cardHolderName.value
                   }
               }
           }
       );
       
       if(error) {
           showErrors.style.display = 'block'
           showErrors.innerText = (error.type == 'validation_error') ? error.message : 'Dados inválidos, verifique e tente novamente!'
           cardButton.classList.remove('disabled')
           cardButton.firstChild.data = 'Enviar'
           return;
       }
   
       let token = document.createElement('input')
       token.setAttribute('type', 'hidden')
       token.setAttribute('name', 'token')
       token.setAttribute('value', setupIntent.payment_method)
       form.appendChild(token)
       form.submit()
   
   })
   
</script>