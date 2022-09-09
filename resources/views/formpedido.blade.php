@extends('layout.app')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
    $('.btnprn').printPage();
    });
</script>
<style>
    .select2-container,
    .select2-selection--single,
    .select2-selection__rendered {
        height: 38px !important;
        line-height: 38px !important;
        vertical-align: middle !important;
        text-align: left !important;
        
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}" />


@if(session('success_message'))
<script>
 Swal.fire({
  position: 'middle-center',
  icon: 'success',
  title: 'Pedido Gerado com Sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
@endif

@if(session('update_message'))
<script>
 Swal.fire({
  position: 'middle-center',
  icon: 'success',
  title: 'Orçamento Alterado com Sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
@endif
    
@if(session('gerar_pedido_message'))
<script>
  const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'success',
  title: 'Pedido Gerado com sucesso!'
})
</script>
@endif


@if (session('deleted_message'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'middle-center',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        
        Toast.fire({
            icon: 'success',
            title: 'Item excluido com sucesso!'
        })
    </script>
@endif

    <div class="container">                       
        <div class="row">
          <div class="col-sm-7"><h4>Pedido</h4></div>
          <div class="col-sm-5 text-end">
            @if(@$ResultPedido->aprovado == 'S')
            <button id="BtnPrint" class="btn-sm btn-info "><a href="{{ url("pedido-pdf/$ResultPedido->id") }}" target="_black"><i class="bi bi-printer"></i> Imprimir</a></button>
            <button class="btn-sm btn-primary "> <i class="bi bi-check-circle-fill"></i> Pedido Aprovado {{ $ResultPedido->FormatData() }}</button>
            @else
            <i class="text-alert text-danger fs-6">** Informe as condições financeiras e salve o pedido!</i>
            @endif
          </div>  
          
          <div class="col-sm-12">
                <form method="POST" action="@if(!@$ResultPedido){{ route('pedido.salvar') }}@else {{ route('pedido.atualizar',@$ResultPedido->id) }} @endif">
                @csrf                                                

                  <div class="row">
                    @if(@$ResultPedido == true)
                      <div class="col-sm-12 p-1 Pedido">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i
                                      class="bi bi-chat-square-text-fill"></i></span>
                                      <input type="text" class="form-control" value="{{ $ResultPedido->id }}" readonly>
                          </div>
                      </div>
                      @endif
                      <div class="col-sm-12 p-1 Pedido">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i
                                      class="bi bi-chat-square-text-fill"></i></span>
                              <select id="entidade_id" name="entidade_id" class="form-control" required disabled>
                                  <option value="">Cliente</option>
                                  @foreach ($ResultEntidade as $key => $result)
                                      <option value="{{ $result->id }}" @if($result->id == @$ResultPedido->entidade_id) selected @endif>{{ $result->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-4 p-1 Pedido">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i
                                      class="bi bi-calendar-date"></i></span>
                              <input id="date" name="date" type="date" class="form-control" value="@if(!@$ResultPedido){{ date('Y-m-d') }}@else{{ substr($ResultPedido->date,0,10) }}@endif" readonly>
                          </div>
                      </div>

                      <div class="col-sm-3 p-1 Pedido">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i class="bi bi-cash-coin"></i></span>
                              <input id="totalnota" name="totalnota" type="text" class="form-control"
                                  placeholder="Total da NFe" value="{{ @$ResultPedido->total }}" onKeyUp="mascaraMoeda(this, event)" readonly>
                          </div>
                      </div>                      
                      
                      <div class="col-sm-2 p-1 Pedido">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-upc-scan"></i>
                              </span>
                              <input id="valor_frete" name="valor_frete" type="text" class="form-control" readonly
                                  placeholder="R$ do Frete" value="{{ @$ResultPedido->valor_frete }}" onKeyUp="mascaraMoeda(this, event)" onblur="calculaTotal()">
                          </div>
                      </div>

                      <div class="col-sm-3 p-1 Pedido">
                        <div class="input-group">
                            <span class="input-group-addon input-group-text"> <i class="bi bi-upc-scan"></i>
                            </span>
                            <input id="grand_total" name="grand_total" type="text" class="form-control"
                                placeholder="SubTotal" value="{{ number_format(@$ResultPedido->total + @$ResultPedido->valor_frete,2,'.','') }}" readonly>
                        </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="col-sm-12 p-1 Pedido">
                        <textarea name="note" class="form-control" style="width: 100%; height:100px;" placeholder="Observação do Orçamento">{{ @$ResultPedido->note }}</textarea>
                    </div>
                  </div>

                 
                 
                  <div class="row "> 
                    <div class="col-sm-12 p-1"><strong>Relação de Produtos da Entrada</strong></div> 
                    
                    @if(@$ResultPedido->aprovado == 'S')
                    <div id="consultaProdutos" class="col-sm-5 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-search"></i> </span>                                                                
                              <select id="product_name" name="product_name" class="form-control select2" data-width="90%" disabled>
                                  <option value="">Produto </option>
                              </select>
                          </div>                          
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i
                                      class="bi bi-braces-asterisk"></i> </span>
                              <input id="quantity" name="quantity" type="text" class="form-control"
                                  placeholder="Qtde" value="1" readonly >
                          </div>
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-cash-coin"></i>
                              </span>
                              <input id="price" name="price"  type="text" class="form-control"
                                  placeholder="R$" value="" onKeyUp="mascaraMoeda(this, event)" readonly >
                          </div>
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-cash-coin"></i>
                              </span>
                              <input id="total" name="total" type="text" class="form-control"
                                  placeholder="R$" value="" onKeyUp="mascaraMoeda(this, event)" readonly >
                          </div>
                      </div>  
                      
                      <div class="col-sm-1 p-1">
                        <div class="input-group">
                            <input type="button" id="add" class="btn btn-success w-100" value="[+]" disabled="disabled">
                        </div>
                    </div>

                     {{--  <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-align-bottom"></i>
                              </span>
                              <input id="largura" name="largura" type="text" class="form-control"
                                  placeholder="Largura" value="" >
                          </div>
                      </div>

                      <div class="col-sm-3 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-align-center"></i>
                              </span>
                              <input id="espessura" name="espessura" type="text" class="form-control"
                                  placeholder="Espessura" value="" >
                          </div>
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-align-start"></i>
                              </span>
                              <input id="comprimento" name="comprimento" type="text" class="form-control"
                                  placeholder="Comprimento" value="" >
                          </div>
                      </div> --}}

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i
                                      class="bi bi-braces-asterisk"></i>
                              </span>
                              <input id="qtde_quadrado" name="qtde_quadrado" type="text" class="form-control"
                                  placeholder="Qtde MT²" value="" readonly>
                          </div>
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i
                                      class="bi bi-braces-asterisk"></i>
                              </span>
                              <input id="total_quadrado" name="total_quadrado" type="text" class="form-control"
                                  placeholder="Total MT²" value="" readonly>
                          </div>
                      </div>
                     

                  </div>
                  @endif
                  <div class="row">
                      <table id='tableItens' class="table table-striped w-100 Pedido">
                          <thead>
                              <tr>
                                  <th style="width: 20%">Produto</th>
                                  <th style="width: 10%" class="text-center">Valor</th>
                                  <th style="width: 10%" class="text-center">Qtde</th>
                                  <th style="width: 10%" class="text-center">Total</th>
                                  <th style="width: 10%" class="text-center">Qtd M²</th>
                                  <th style="width: 5%" class="text-center">Total M²</th>
                                  <th style="width: 5%" class="text-center">#</th>
                              </tr>
                              <tbody id="divItens">
                              @if($ResultPedido == true)
                              @foreach($ResultItemsPedido as $result)
                                <tr>
                                    <td style="width: 20%">{{ $result->Product() }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->unit_price }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->quantity }}</td>
                                    <td style="width: 10%" class="text-center vlr">{{ $result->subtotal }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->qtde_quadrado }}</td>
                                    <td style="width: 5%" class="text-center">{{ $result->total_quadrado }}</td>
                                    <td style="width: 5%" class="text-center">
                                        {{-- <a href="javascript:del({{ $result->id }},{{ $result->pedido_id }} )"><button type="button" class="btn btn-danger btn-sm">[-]</button></a> --}}
                                    </td>
                                </tr>
                            @endforeach   
                            @endif
                              </tbody>
                          </thead>                              
                        </table>
                  </div>
                  
                  
                 
                  <div id="financeiro" class="row">
                    <div class="col-sm-12 p-1"><strong>Movimento Financeiro</strong></div>
                     
                    @if(@$ResultPedido->aprovado == 'S')
                      <table id='tableItens' class="table table-striped w-100 Pedido">
                          <thead>
                              <tr>
                                  <th style="width: 2%">#</th>
                                  <th style="width: 10%" class="text-center">Forma de Pagamento</th>
                                  <th style="width: 10%" class="text-center">Centro de Custo</th>
                                  <th style="width: 10%" class="text-center">Histórico</th>
                                  <th style="width: 10%" class="text-center">Valor</th>
                                  <th style="width: 10%" class="text-center">Data</th>
                                  <th style="width: 10%" class="text-center">Situação</th>
                                  <th style="width: 10%" class="text-center">Data</th>
                              </tr>
                              <tbody id="divItens">
                              @if($ResultPedido == true)
                              @foreach($ResultLancamento as $key => $result)
                                <tr>
                                    <td style="width: 2%">{{ $key+1 }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->FormaPagamento(); }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->CentroCusto(); }}</td>
                                    <td style="width: 10%" class="text-center vlr">{{ $result->Historico(); }}</td>
                                    <td style="width: 10%" class="text-center">{{ number_format($result->price,2,'.','') }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->FormatData() }}</td>
                                    <td style="width: 5%" class="text-center">@if($result->payday == true) Recebido @else Em aberto @endif</td>
                                    <td style="width: 5%" class="text-center">{{ $result->payday }}</td>
                                </tr>
                            @endforeach   
                            @endif
                              </tbody>
                          </thead>                              
                        </table>
                    <!--caso o pedido já foi aprovado, aparece apenas as parcelas -->
                    @else

                    @if(!@$ResultEntrada) 
                    <div class="col-sm-3 p-1">Centro de Custo<br>
                      <div class="input-group">
                        <span class="input-group-addon input-group-text"><i class="bi bi-arrow-90deg-right"></i></span>
                        <select id="centrocusto_id" name="centrocusto_id" class="form-control" required>
                          <option value="">Centro de Custo</option>
                          @foreach ($ResultCentroCusto as $result)
                          <option value="{{ $result->id }}"  @if($result->id == @$ResultEntrada->centrocusto_id) selected @endif>{{ $result->name }}</option>
                          @endforeach
                        </select>
                        </div>
                      </div>  
                      <div class="col-sm-2 p-1">Histórico<br>
                        <div class="input-group">
                          <span class="input-group-addon input-group-text"><i class="bi bi-arrow-90deg-left"></i></span>                                  
                          <select id="historico_id" name="historico_id" class="form-control" required>
                              <option value="">Histórico</option>  
                              @foreach ($ResultHistorico as $result)
                              <option value="{{ $result->id }}"  @if($result->id == @$ResultEntrada->historico_id) selected @endif>{{ $result->name }}</option>
                              @endforeach                            
                          </select>
                        </div>
                      </div>                                                                                 
                      <div class="col-sm-2 p-1">Forma de Pagamento<br>
                        <div class="input-group">
                          <span class="input-group-addon input-group-text"><i class="bi bi-currency-exchange"></i></span>
                          <select id="formapagamento_id" name="formapagamento_id[]" class="form-control" required>
                              <option value="">Forma de Pagamento</option>
                              @foreach($ResultFormaPagamento as $result)
                              <option value="{{ $result->id }}"                            
                                  @if($ResultFormaPagamento[0]['formapagamento_id'] == $result->id) selected="selected" @endif>{{ $result->name }}</option>
                              @endforeach
                          </select>
                          </div>
                      </div>
                                  
                      <div class="col-sm-1 p-1">Parcela<br>
                        <input type="number" name="parcela_id[]" class="form-control" value="1" readonly>
                      </div>
                      <div class="col-sm-1 p-1">Valor<br>
                          <input type="text" id="parcela_price" name="parcela_price[]" class="form-control" value="" onKeyUp="mascaraMoeda(this, event)" required>
                      </div>
                      <div class="col-sm-2 p-1">Data<br>
                          <input type="date" name="parcela_date[]" class="form-control" value="" required>
                      </div>
                      <div class="col-sm-1 p-1"><br>
                          <input type="button" id="add-financeiro" class="btn btn-info w-100" value="[+]">
                      </div>
                                                
                    <div id="divFinanceiro" class="col-sm-12 p-1"></div> 

                    @else
                    @foreach($ResultLancamento as $key => $result)
                      
                    <div class="col-sm-7 p-1">Forma de Pagamento<br>
                        <div class="input-group">
                          <span class="input-group-addon input-group-text"><i class="bi bi-currency-exchange"></i></span>
                          <select id="formapagamento_id" name="formapagamento_id[]" class="form-control" required>
                              <option value="">Forma de Pagamento</option>
                              @foreach($ResultFormaPagamento as $resultP)
                              <option value="{{ $resultP->id }}"                            
                                  @if($resultP->id == $result->formapagamento_id) selected="selected" @endif disabled>{{ $resultP->name }}</option>
                              @endforeach
                          </select>
                          </div>
                      </div>
                    <div class="col-sm-1 p-1">Parcela<br>
                        <input type="number" name="parcela_id[]" class="form-control" value="{{ $key+1 }}" readonly>
                      </div>
                      <div class="col-sm-1 p-1">Valor<br>
                          <input type="text" id="parcela_price" name="parcela_price[]" class="form-control" value="{{ $result->price }}" onKeyUp="mascaraMoeda(this, event)" readonly>
                      </div>
                      <div class="col-sm-2 p-1">Data<br>
                          <input type="date" name="parcela_date[]" class="form-control" value="{{ $result->date }}" readonly>
                      </div>
                      <div class="col-sm-1 p-1"><br>
                         
                      </div>
                      @endforeach
                    @endif
                  </div>

                  @endif
                  <!--fim do processo dos pagamentos-->
                  <div id="entrega" class="row Pedido">                  
                    <div class="col-sm-12 p-1"><strong>Dados para entrega</strong></div>
                    <div class="col-sm-6 p-1">Endereço<br>
                        <input type="text" id="delivery_address" name="delivery_address" class="form-control" value="{{ @$ResultPedido->delivery_address }}" >
                      </div>
                      <div class="col-sm-1 p-1">Número<br>
                          <input type="text" id="delivery_number" name="delivery_number" class="form-control" value="{{ @$ResultPedido->delivery_number}}">
                      </div>
                      <div class="col-sm-2 p-1">CEP<br>
                          <input type="text" id="delivery_zip_code" name="delivery_zip_code" class="form-control" value="{{ @$ResultPedido->delivery_zip_code}}">
                      </div>
                      <div class="col-sm-3 p-1">Bairro<br>
                          <input type="text" id="delivery_district" name="delivery_district" class="form-control" value="{{ @$ResultPedido->delivery_district}}">
                      </div>
                      <div class="col-sm-5 p-1">Cidade<br>
                          <input type="text" id="delivery_city" name="delivery_city" class="form-control" value="{{ @$ResultPedido->delivery_city }}">
                      </div>
                      <div class="col-sm-1 p-1">Estado<br>
                          <input type="text" id="delivery_state" name="delivery_state" class="form-control" value="{{ @$ResultPedido->delivery_state }}">
                      </div>

                      <div class="col-sm-3 p-1">Telefone<br>
                          <input type="text" id="delivery_fone" name="delivery_fone" class="form-control" value="{{ @$ResultPedido->delivery_fone }}">
                      </div>
                      <div class="col-sm-3 p-1">Telefone<br>
                          <input type="text" id="delivery_fone2" name="delivery_fone2" class="form-control" value="{{ @$ResultPedido->delivery_fone2 }}">
                      </div>
                      
                    
                   
                  </div>
            </div>
        </div>

        <hr>
        <div class="row p-1">
            <div class="col-sm-12 text-end">
                <a href="{{ url('/Pedido') }}"><button type="button" class="btn btn-info"><i
                            class="bi bi-reply-all-fill"></i> Voltar</button></a>
                @if(@$ResultPedido->aprovado == "N")
                <button type="submit" id="salvar" class="btn btn-success" disabled="disabled"><i class="bi bi-plus-circle-fill"></i> Salvar</button> 
                @endif
               
            </div>
        </div>

    </div>

    <script> 
    $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            $('#sidebarCollapse').trigger('click');
    });

        String.prototype.reverse = function(){
        return this.split('').reverse().join(''); 
      };    
      
      //caulcula os campos de frente e totias de grid e campo total
      function calculaTotal() {
        var colunas = document.querySelectorAll('.vlr');
        var numColunas = colunas.length;
        var soma = 0;
        var grand_total = 0; 
        var converte = 0; 
        var frete = parseFloat($('#valor_frete').val());      
        
        for (let i = 0; i < numColunas; i++) {
            converte = parseFloat(colunas[i].textContent.replace('R$ ', '').replace(',', '.'));
            soma     = parseFloat(soma + converte);            
            grand_total = parseFloat(soma + frete);

            $('#totalnota').val(soma.toFixed(2));
            $('#grand_total').val(grand_total.toFixed(2));

            //console.log((grand_total))            
        }
      }

      //enquanto o cliente não for selecionado não habilita os botões de 
      //add produto, add financeiro e salvar
      $(document).ready(function () {
         
        //script da data table
        var table = $('#datatable-buttons').DataTable({
                     destroy: true,
                     responsive:true,
                     buttons:(['print','excel','pdf']),                   
                     searching: true,                    
                     language: {
                         url: '{{ URL::asset('DataTables-1.12.1/pt-BR.json')}}'
                     },
                     initComplete: function () {
                         setTimeout( function () {
                             table.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
                         }, 10 );
                     }
            });
    
            $('#add-financeiro').click(function() { 
            
            var index = $('.line_financeiro').length;
                        
            var html_itens = [];
            html_itens = `<div id="index" class="row p-1 line_financeiro">
                          <div class="col-sm-3 p-1"></div>
                          <div class="col-sm-2 p-1"></div>
                          <div class="col-sm-2 p-1">
                            <div class="input-group">
                              <span class="input-group-addon input-group-text"><i class="bi bi-currency-exchange"></i></span>
                              <select id="formapagamento_id" name="formapagamento_id[]" class="form-control" required>
                                  <option value="">Forma de Pagamento</option>
                                  @foreach($ResultFormaPagamento as $result)
                                  <option value="{{ $result->id }}"                            
                                      @if($ResultFormaPagamento[0]['formapagamento_id'] == $result->id) selected="selected" @endif>{{ $result->name }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-1 p-1"><input type="number" name="parcela_id[]" class="form-control" value="1"></div>
                          <div class="col-sm-1 p-1"><input type="number" id="parcela_price" name="parcela_price[]" class="form-control" value="" onKeyUp="mascaraMoeda(this, event)"></div>
                          <div class="col-sm-2 p-2"><input type="date" name="parcela_date[]" class="form-control" value=""></div>
                          <div class="col-sm-1 p-1"><input type="button" class="btn btn-danger" onclick="$(this).parents('.line_financeiro').remove()" value="[-]"></div>
                          </div>`;
          

            $("#divFinanceiro").append(html_itens);           

        });         

      if($('#entidade_id').val() == ''){
        $('#entidade_id').on('input change', function () {
            if ($(this).val() != '') {
                $('#add').prop('disabled', false);
                $('#add-financeiro').prop('disabled', false);
                $('#salvar').prop('disabled', false);
            }
            else {
                $('#add').prop('disabled', true);
                $('#add-financeiro').prop('disabled', true);
                $('#salvar').prop('disabled', true);
            }
        });
      }else{
                $('#add').prop('disabled', false);
                $('#add-financeiro').prop('disabled', false);
                $('#salvar').prop('disabled', false);
      }
    });
    

        function del(codigo, pedido_id) {

            Swal.fire({
                title: 'Excluir?',
                text: "Esta ação vai apagar o item selecionado!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '/ItemPedido/Deletar/' + codigo + '/' + pedido_id;                    
                }
            })
        }

        
        function aprovarPedido(codigo, pedido_id) {

            Swal.fire({
                title: 'Aprovar Pedido de Venda?',
                text: "Esta ação vai baixar os itens do estoque, assim como gerar informações fincanceiras e atribuí-las ao cliente informado!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, aprovar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '/AutotizaPedido/' + codigo + '/' + pedido_id;                    
                }
            })
        }

        //seta o cursor do mouse na consulta
        window.jQuery(document).on('select2:open', e => {
            const id = e.target.id;
            const target = document.querySelector(`[aria-controls=select2-${id}-results]`);
            target.focus();
        });

        $("#product_name").select2({

            ajax: {
                url: "/ConsultaProdutos",
                type: "post",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(response) {
                    return {
                        results: response,
                    };
                },
                cache: true,
            },                               
        });                


        //multiplica o valor pela quantidade de itens
        //resultado joga no total
        $("#price, #quantity").keyup(function () {     
          var product_id = $("#product_name").val();
          var quantity = $("#quantity").val();
          var price = $("#price").val();       
          
          var TotalOperacao = (quantity * price).toFixed(2);
          $("#total").val(TotalOperacao);
          
         
        })


        $("#entidade_id").change(function() {

            var entidade_id = $('#entidade_id').val();                  

        // AJAX request
         $.ajax({
            url: "/ConsultaEnderecoEntidade/" + entidade_id,
            type: 'GET',
            // headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
            data: {
            id: entidade_id, 
            }, 
            dataType: "json",

            success: function(resposta) {  
             $("#delivery_address").val(resposta.address);
             $("#delivery_number").val(resposta.number);
             $("#delivery_fone").val(resposta.fone);
             $("#delivery_fone2").val(resposta.fone2);
             $("#delivery_district").val(resposta.district);
             $("#delivery_city").val(resposta.city);
             $("#delivery_state").val(resposta.state);
             $("#delivery_zip_code").val(resposta.zip_code);
            }

        }) 

    })
        
    //consulta produtos de acordo com a classificação do cliente
    $("#product_name").change(function() {
            var id = $("#product_name").val();
            var remove1 = id.split("[ ");
            var codProduto = remove1[1].split(" ]");
            //captura a entidade para que possa ser puxada a tabela 
            //de acordo com o tipo da entidade
            var entidadepedido = $('#entidade_id').val();           
       

        // AJAX request
         $.ajax({
            url: "/ConsultaValorProduto/" + codProduto[0],
            type: 'GET',
            // headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
            data: {
            id: id, 
            identidade: entidadepedido, 
            }, 
            dataType: "json",

            success: function(resposta) {  
             $("#price").val(resposta.price);
            }

        }) 

    })

        var cont = 0;
        $('#add').click(function() {                    
            
          var product_id      = $("#product_name").val();
          var quantity        = $("#quantity").val();
          var price           = $("#price").val();                    
          var total           = $("#total").val();                    
          var largura         = $("#largura").val();
          var espessura       = $("#espessura").val();
          var comprimento     = $("#comprimento").val();
          var qtde_quadrado   = $("#qtde_quadrado").val();
          var total_quadrado  = $("#total_quadrado").val();        

            if(product_id.length == 0){
                        $("#product_name").focus();
                    return false;
            }
            if(quantity.length == 0){
                        $("#quantity").focus();
                    return false;
            }
            if(price.length == 0){
                        $("#price").focus();
                    return false;
            }
            if(total.length == 0){
                        $("#total").focus();
                    return false;
            }
            if(largura.length == 0){
                        $("#largura").focus();
                    return false;
            }
            if(espessura.length == 0){
                        $("#espessura").focus();
                    return false;
            }
            if(comprimento.length == 0){
                        $("#comprimento").focus();
                    return false;
            }
            if(qtde_quadrado.length == 0){
                        $("#qtde_quadrado").focus();
                    return false;
            }
            if(total_quadrado.length == 0){
                        $("#total_quadrado").focus();
                    return false;
            }

            var html_itens = [];
   
            html_itens += "<tr class='linha"+cont+"'>";
            html_itens += "<td style='width: 20%'><input name='product_id[]' type='hidden' value='"+ product_id + "'></td>";
            html_itens += "<td style='width: 10%' align='right'><input name='price[]' type='hidden' value='"+ price + "'></td>";
            html_itens += "<td style='width: 10%' align='right'><input name='quantity[]' type='hidden' value='"+ quantity + "'></td>";
            html_itens += "<td style='width: 10%' align='right'><input name='total[]' type='hidden' value='"+ total + "'></td>";
            html_itens += "<td style='width: 10%' align='right'><input name='largura[]' type='hidden' value='"+ largura + "'></td>";
            html_itens += "<td style='width: 10%' align='right'><input name='espessura[]' type='hidden' value='"+ espessura + "'></td>";
            html_itens += "<td style='width: 10%' align='right'><input name='comprimento[]' type='hidden' value='"+ comprimento + "'></td>";
            html_itens += "<td style='width: 10%' align='right'><input name='qtde_quadrado[]' type='hidden' value='"+ qtde_quadrado + "'></td>";
            html_itens += "<td style='width: 10%' align='right'><input name='total_quadrado[]' type='hidden' value='"+ total_quadrado + "'></td>";
            html_itens += "</tr>";
            html_itens += "<tr class='linha"+cont+" alert alert-warning'>";
            html_itens += "<td style='width: 20%'>" + product_id + "</td>";
            html_itens += "<td style='width: 10%' class='text-center'>" + price + "</td>";
            html_itens += "<td style='width: 10%' class='text-center'>" + quantity + "</td>";
            html_itens += "<td style='width: 10%' class='text-center vlr'>" + total + "</td>";
            html_itens += "<td style='width: 10%' class='text-center'>" + largura + "</td>";
            html_itens += "<td style='width: 10%' class='text-center'>" + espessura + "</td>";
            html_itens += "<td style='width: 10%' class='text-center'>" + comprimento + "</td>";
            html_itens += "<td style='width: 10%' class='text-center'>" + qtde_quadrado + "</td>";
            html_itens += "<td style='width: 10%' class='text-center'>" + total_quadrado + "</td>";
            html_itens += "<td style='width: 10%' class='text-center'>";
            html_itens += "<button type='button' onclick='removerLinha("+cont+")' class='btn btn-danger btn-sm'>[-]</button></td>";
            html_itens += "</tr>";
           
            $("#divItens").append(html_itens);
            limpa_campos();
            calculaTotal();
            $("#product_name").focus(); 
            cont++;

        });

        //remove linha adicionado na div temporária
        function removerLinha(id){           
            //remove a linha da tabela temporária
            $(".linha"+id).remove();
            //recalcula todo o processo de valores
            calculaTotal();
      }

      //limpa os campos após a inserção no grid temporário
        function limpa_campos() {
                        $("#product_name").empty();       
                        $("#quantity").val('1');
                        $("#price").val('');
                        $("#total").val('');
                        $("#largura").val('');
                        $("#espessura").val('');
                        $("#comprimento").val('');
                        $("#qtde_quadrado").val('');
                        $("#total_quadrado").val('');
                 }

               
    </script>
@endsection
