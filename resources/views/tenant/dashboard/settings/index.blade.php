@section('title', trans('system.settings'))
<x-app-layout>
   <x-slot name="title">
      {{ trans('system.settings') }}
   </x-slot>
   <x-slot name="btns">
      <div class="btn-list">
         <a href="./" class="btn btn-white">
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
            <form class="needs-validation" role="form" action="{{ route('settings.updateTenant') }}" method="post" enctype="multipart/form-data" novalidate>
               @csrf
               @method('PUT')
               <div class="card mb-3">
                  <div class="card-header">
                     <h3 class="card-title">{{ trans('system.tenant.organization_data') }}</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6 col-xl-12">
                           <div class="mb-3">
                              <div class="row g-2">
                                 <div class="col-12 col-md-6">
                                    <label class="form-label">{{ trans('system.tenant.name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{$tenant->name}}" required>
                                 </div>
                                 <div class="col-12 col-md-3">
                                    <label class="form-label">{{ __('Email') }}</label>
                                    <input type="text" class="form-control" name="email" value="{{$tenant->email}}" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-end">
                     <div class="d-flex">
                        <button type="submit" class="btn btn-primary ms-auto">{{ trans('system.save') }}</button>
                     </div>
                  </div>
               </div>
            </form>
            <form class="needs-validation" role="form" action="{{ route('settings.billingAddress', $method->id ?? '') }}" method="post" enctype="multipart/form-data" novalidate>
               @csrf
               <div class="card mb-3">
                  <div class="card-header">
                     <h3 class="card-title"> {{ trans('system.billing_data') }}</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6 col-xl-12">
                           <div class="mb-3">
                              <div class="row mb-3">
                                 <div class="col-12 col-md-6">                                  
                                    <label class="form-label">{{ trans('system.tenant.owner') }}</label>
                                    <input type="text" name="name" class="form-control" value="{{$method->billing_details->name ?? ''}}" required>
                                 </div>
                                 <div class="col-12 col-md-3">
                                    <label class="form-label">{{ __('Email') }}</label>
                                    <input type="text" class="form-control" name="email" value="{{$method->billing_details->email ?? ''}}" required>
                                 </div>
                                 <div class="col-12 col-md-3">
                                    <label class="form-label" id="tax_id">{{ trans('system.tenant.tax') }}</label>
                                    <input type='text' class="form-control" name='tax_id' value="{{$method->boleto->tax_id ?? ''}}" minlength="11" maxlength="14" required>
                                    <small class="text-help">{{ trans('system.tenant.tax_helper') }}</small>
                                 </div>
                              </div>
                           </div>
                           <div class="mb-3">
                              <div class="row mb-3">
                                 <div class="col-12 col-md-2">                                  
                                    <label class="form-label">{{ trans('system.zipcode') }}</label>
                                    <input type="text" name="zipcode" class="form-control" data-mask="00000-000" data-mask-visible="false" autocomplete="off" onblur="pesquisacep(this.value);" value="{{$method->billing_details->address->postal_code ?? ''}}" required>
                                 </div>
                                 <div class="col-12 col-md-5">
                                    <label class="form-label">{{ trans('system.address') }}</label>
                                    <input type="text" class="form-control" name="line1" value="{{$method->billing_details->address->line1 ?? ''}}" required>
                                 </div>
                                 <div class="col-8 col-md-4">
                                    <label class="form-label">{{ trans('system.city') }}</label>
                                    <input type="text" class="form-control" name="city" value="{{$method->billing_details->address->city ?? ''}}" required>
                                 </div>
                                 <div class="col-4 col-md-1">
                                    <label class="form-label">{{ trans('system.state') }}</label>
                                    <input type="text" class="form-control" name="state" value="{{$method->billing_details->address->state ?? ''}}" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-end">
                     <div class="d-flex">
                        <button type="submit" class="btn btn-primary ms-auto">{{ trans('system.save') }}</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   @push('scripts')
   <script>
      function limpa_formulário_cep() {
              //Limpa valores do formulário de cep.
              document.getElementsByName('line1')[0].value=("");
              document.getElementsByName('city')[0].value=("");
              document.getElementsByName('state')[0].value=("");
      }
      
      function meu_callback(conteudo) {
          if (!("erro" in conteudo)) {
              console.log(conteudo);
              //Atualiza os campos com os valores.
              document.getElementsByName('line1')[0].value=(conteudo.logradouro +' - '+ conteudo.bairro);
              document.getElementsByName('city')[0].value=(conteudo.localidade);
              document.getElementsByName('state')[0].value=(conteudo.uf);
              Toast.fire({ icon: 'success', title: '{{trans('system.zip_code_found')}}'})
          } //end if.
          else {
              //CEP não Encontrado.
              limpa_formulário_cep();
              Toast.fire({ icon: 'error', title: '{{trans('system.notfound_zipcode')}}'})
          }
      }
          
      function pesquisacep(valor) {
          
          //Nova variável "cep" somente com dígitos.
          var cep = valor.replace(/\D/g, '');
      
          //Verifica se campo cep possui valor informado.
          if (cep != "") {
      
              //Expressão regular para validar o CEP.
              var validacep = /^[0-9]{8}$/;
      
              //Valida o formato do CEP.
              if(validacep.test(cep)) {
      
                  //Preenche os campos com "..." enquanto consulta webservice.
                  document.getElementsByName("line1").value="...";
                  document.getElementsByName('city').value="...";
                  document.getElementsByName('state').value="...";
      
                  //Cria um elemento javascript.
                  var script = document.createElement('script');
      
                  //Sincroniza com o callback.
                  script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
      
                  //Insere script no documento e carrega o conteúdo.
                  document.body.appendChild(script);
      
              } //end if.
              else {
                  //cep é inválido.
                  limpa_formulário_cep();
                  Toast.fire({ icon: 'error', title: '{{trans('system.invalid_format_zipcode')}}'})
              }
          } //end if.
          else {
              //cep sem valor, limpa formulário.
              limpa_formulário_cep();
          }
      };
      
   </script>
@endpush
</x-app-layout>
