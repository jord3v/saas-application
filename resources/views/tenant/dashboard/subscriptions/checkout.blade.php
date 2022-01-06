@php
$_GET['payment'] = isset($_GET['payment']) ? $_GET['payment'] : 'cartao';
$options = array('', 'boleto', 'cartao', 'pix'); 
if (!in_array($_GET['payment'], $options)) { 
header('Location: '.route('dashboard'));
exit();
}
@endphp
@section('title', trans('system.checkout'))
<x-app-layout>
   <x-slot name="title">
      {{ trans('system.checkout') }}
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
               {{ trans('system.back') }}
            </a>
         </span>
      </div>
   </x-slot>
   <div class="container-xl">
      <div class="row row-cards">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">{{ trans('system.select_payment_method') }}</h3>
               </div>
               <div class="card-body">
                  <form class="needs-validation" action="{{ route('subscriptions.store') }}" method="post" class="form" id="form" novalidate>
                     @csrf
                     <div class="form-group mb-3">
                        <label class="form-label">{{ trans('system.payment_method') }}</label>
                        <div>
                           <select class="form-select" name="method_payment" onchange="window.location = this.options[this.selectedIndex].value" required>
                              <option value="">{{ trans('system.payment_method') }}</option>
                              <option value="?payment=boleto" {{$_GET['payment'] == 'boleto' ? 'selected':''}}>{{ trans('system.billet') }}</option>
                              <option value="?payment=cartao" {{$_GET['payment'] == 'cartao' ? 'selected':''}}>{{ trans('system.credit_card') }}</option>
                              <option value="?payment=pix" {{$_GET['payment'] == 'pix' ? 'selected':''}}>Pix</option>
                           </select>
                        </div>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">{{ trans('system.plan') }}</label>
                        <div class="row">
                           @forelse ($plans as $plan)
                           <div class="col-sm-6 col-lg-4">
                              <div class="card card-md">
                                 <div class="card-body text-center">
                                    <div class="text-uppercase text-muted font-weight-medium">{{$plan->product->name}}</div>
                                    <div class="display-6 my-3">R$ {{$plan->unit_amount/100}} <span style="font-size: 1.5rem;">/{{ trans('system.'.$plan->recurring->interval) }}</span> </div>
                                    <ul class="list-unstyled lh-lg">
                                       @forelse (collect($plan->product->metadata) as $key => $value)
                                       @if($value == 'true' && $key == 'recommended')
                                       <div class="ribbon ribbon-bookmark bg-green">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                             <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                          </svg>
                                       </div>
                                       @elseif ($value == 'true')
                                       <li>
                                          <strong class="text-success">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                             </svg>
                                          </strong>
                                          {{$key}}
                                       </li>
                                       @elseif ($value == 'false')
                                       <li>
                                          <strong class="text-danger">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                             </svg>
                                          </strong>
                                          {{$key}}
                                       </li>
                                       @else
                                       <li><strong>{{$value}}</strong> {{$key}}</li>
                                       @endif
                                       @empty
                                       @endforelse
                                    </ul>
                                    <div class="text-center mt-4">
                                       <label class="btn w-100">
                                       <input type="radio" name="plan" value="{{$plan->id}}" required> <span class="px-2">{{ trans('system.choose_plan') }}</span>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @empty
                           <div class="col">
                              {{ trans('system.nothing_found') }}
                           </div>
                           @endforelse
                        </div>
                     </div>
                     <div class="py-3">
                        @if($_GET['payment'] == 'cartao')
                        <div class="cartao">
                           <div class="form-group mb-3">
                              <label class="form-label">{{__('Name')}}</label>
                              <div>
                                 <input type="text" class="form-control" id="card-holder-name" value="{{auth()->user()->name}}">
                                 <small class="form-hint">{{ trans('system.helper_credit_card') }}</small>
                              </div>
                           </div>
                           <div class="form-group mb-3 ">
                              <div>
                                 <label class="form-label">{{ trans('system.credit_card') }}</label>
                                 <div id="card-element"></div>
                              </div>
                           </div>
                        </div>
                        @endif
                        @if($_GET['payment'] == 'pix')
                        <div class="pix">
                           PIX
                        </div>
                        @endif
                     </div>
                     <div class="form-footer">
                        <strong id="show-errors" style="display: none;" class="text-danger py-2"></strong>
                        <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">{{ trans('system.submit') }}</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   @push('scripts')
<script>
   function selectCurSort() {
      var match = window.location.href.split('?')[1];
      $('#sort').find('option[value$="'+match+'"]').attr('selected',true);
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
        cardButton.firstChild.data = '{{trans('system.validating')}}'
        
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
           showErrors.innerText = (error.type == 'validation_error') ? error.message : '{{trans('system.invalid_data')}}'
           cardButton.classList.remove('disabled')
           cardButton.firstChild.data = '{{ trans('system.submit') }}'
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
@endpush
</x-app-layout>