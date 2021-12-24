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
                   <h3 class="card-title">Selecione o plano e a forma de pagamento</h3>
                </div>
                <div class="card-body">
                   <form action="{{ route('subscriptions.store') }}" method="post" id="form">
                      @csrf
                      <div class="mb-3">
                         <label class="form-label">Plano</label>
                         <div class="row g-2">
                            <div class="col-4">
                               <label class="form-selectgroup-item flex-fill">
                                  <input type="radio" name="plan" value="price_1KA1mLLRsHtC2l7Qacow0iMB" class="form-selectgroup-input" required>
                                  <div class="form-selectgroup-label d-flex align-items-center p-3">
                                     <div class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                     </div>
                                     <div class="form-selectgroup-label-content d-flex align-items-center">
                                        <div>
                                           <div class="font-weight-medium">Plano básico</div>
                                           <div class="text-muted">R$ 29,99/mês</div>
                                        </div>
                                     </div>
                                  </div>
                               </label>
                            </div>
                            <div class="col-4">
                                <label class="form-selectgroup-item flex-fill">
                                   <input type="radio" name="plan" value="price_1K4DCJLRsHtC2l7QF5qhFRm4" class="form-selectgroup-input" required>
                                   <div class="form-selectgroup-label d-flex align-items-center p-3">
                                      <div class="me-3">
                                         <span class="form-selectgroup-check"></span>
                                      </div>
                                      <div class="form-selectgroup-label-content d-flex align-items-center">
                                         <div>
                                            <div class="font-weight-medium">Plano padrão</div>
                                            <div class="text-muted">R$ 49,99/mês</div>
                                         </div>
                                      </div>
                                   </div>
                                </label>
                            </div>
                            <div class="col-4">
                                <label class="form-selectgroup-item flex-fill">
                                   <input type="radio" name="plan" value="price_1K4DDNLRsHtC2l7Q8YWqI0Vc" class="form-selectgroup-input" required>
                                   <div class="form-selectgroup-label d-flex align-items-center p-3">
                                      <div class="me-3">
                                         <span class="form-selectgroup-check"></span>
                                      </div>
                                      <div class="form-selectgroup-label-content d-flex align-items-center">
                                         <div>
                                            <div class="font-weight-medium">Plano premium</div>
                                            <div class="text-muted">R$ 79,99/mês</div>
                                         </div>
                                      </div>
                                   </div>
                                </label>
                             </div>
                         </div>
                      </div>
                      <div class="form-group mb-3">
                         <label class="form-label">Nome completo</label>
                         <div>
                            <input type="text" class="form-control" id="card-holder-name" required>
                            <small class="form-hint">Não armazenamos dados relacionado a cartão de crédito em nosso banco de dados.</small>
                         </div>
                      </div>
                      <div class="form-group mb-3 ">
                         <div>
                            <label class="form-label">Cartão de crédito</label>
                            <div id="card-element"></div>
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
 {{--
 <x-app-layout>
    <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Assinar') }}
       </h2>
    </x-slot>
    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
             <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('subscriptions.store') }}" method="post" id="form">
                   @csrf
                   <div class="col-span-6 sm:col-span-4 mb-4">
                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="card-holder-name" id="card-holder-name">
                   </div>
                   <div class="col-span-6 sm:col-span-4 mb-4">
                      <div id="card-element"></div>
                   </div>
                   <div class="col-span-6 sm:col-span-4 mb-4">
                      <button id="card-button" data-secret="{{ $intent->client_secret }}" type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Enviar</button>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </div>
 </x-app-layout>
 --}}