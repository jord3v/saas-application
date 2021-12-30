<x-app-layout>
   <x-slot name="title">
      {{ __('Meu perfil') }}
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
            Voltar
         </a>
      </div>
   </x-slot>
   <div class="container-xl">
      <div class="row row-cards">
         <div class="col-12">
            <form role="form" action="{{ route('settings.updateTenant') }}" method="post" enctype="multipart/form-data">
               @csrf
               @method('PUT')
               <div class="card mb-3">
                  <div class="card-header">
                     <h3 class="card-title">Dados da organização</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6 col-xl-12">
                           <div class="mb-3">
                              <div class="row g-2">
                                 <div class="col-12 col-md-6">
                                    <label class="form-label">Nome da organização</label>
                                    <input type="text" class="form-control" name="name" value="{{$tenant->name}}" required>
                                 </div>
                                 <div class="col-6 col-md-3">
                                    <label class="form-label">Endereço de e-mail</label>
                                    <input type="text" class="form-control" name="email" value="{{$tenant->email}}" required>
                                 </div>
                                 <div class="col-6 col-md-3">
                                    <label class="form-label">CNPJ</label>
                                    <input type="text" name="cnpj" class="form-control" data-mask="00.000.000/0000-00" data-mask-visible="true" autocomplete="off" value="{{$tenant->cnpj}}">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-end">
                     <div class="d-flex">
                        <button type="submit" class="btn btn-primary ms-auto">Atualizar</button>
                     </div>
                  </div>
               </div>
            </form>
            <form role="form" action="{{ route('settings.billingAddress', $method->id ?? '') }}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="card mb-3">
                  <div class="card-header">
                     <h3 class="card-title">Dados para faturamento</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6 col-xl-12">
                           <div class="mb-3">
                              <div class="row mb-3">
                                 <div class="col-12 col-md-6">                                  
                                    <label class="form-label">Responsável</label>
                                    <input type="text" name="name" class="form-control" value="{{$method->billing_details->name ?? ''}}" required>
                                 </div>
                                 <div class="col-6 col-md-3">
                                    <label class="form-label">Endereço de e-mail</label>
                                    <input type="text" class="form-control" name="email" value="{{$method->billing_details->email ?? ''}}" required>
                                 </div>
                                 <div class="col-6 col-md-3">
                                    <label class="form-label">CPF ou CNPJ</label>
                                    <input type="text" class="form-control" name="tax_id" value="{{$method->boleto->tax_id ?? ''}}" required>
                                 </div>
                              </div>
                           </div>
                           <div class="mb-3">
                              <div class="row mb-3">
                                 <div class="col-12 col-md-2">                                  
                                    <label class="form-label">CEP</label>
                                    <input type="text" name="zipcode" class="form-control" data-mask="00000-000" data-mask-visible="true" autocomplete="off" onblur="pesquisacep(this.value);" value="{{$method->billing_details->address->postal_code ?? ''}}" required>
                                 </div>
                                 <div class="col-6 col-md-5">
                                    <label class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" name="line1" value="{{$method->billing_details->address->line1 ?? ''}}" required>
                                 </div>
                                 <div class="col-6 col-md-4">
                                    <label class="form-label">Cidade</label>
                                    <input type="text" class="form-control" name="city" value="{{$method->billing_details->address->city ?? ''}}" required>
                                 </div>
                                 <div class="col-6 col-md-1">
                                    <label class="form-label">Estado</label>
                                    <input type="text" class="form-control" name="state" value="{{$method->billing_details->address->state ?? ''}}" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-end">
                     <div class="d-flex">
                        <button type="submit" class="btn btn-primary ms-auto">Atualizar</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@9"></script>
   <script>
      const Toast = Swal.mixin({toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2500,
          timerProgressBar: true,
          didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
      })
      function limpa_formulário_cep() {
              //Limpa valores do formulário de cep.
              document.getElementsByName('line1')[0].value=("");
              document.getElementsByName('neighborhood')[0].value=("");
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
              Toast.fire({ icon: 'success', title: 'Endereço localizado com sucesso.'})
          } //end if.
          else {
              //CEP não Encontrado.
              limpa_formulário_cep();
              Toast.fire({ icon: 'error', title: 'O CEP informado não foi encontrado.'})
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
                  document.getElementsByName('neighborhood').value="...";
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
                  Toast.fire({ icon: 'error', title: 'O CEP informado possui formato inválido.'})
              }
          } //end if.
          else {
              //cep sem valor, limpa formulário.
              limpa_formulário_cep();
          }
      };
      
   </script>
</x-app-layout>