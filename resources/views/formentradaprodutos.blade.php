@extends('layout.app')

@section('content')

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
  title: 'Entrada de Produto Efetuada com Sucesso!',
  showConfirmButton: false,
  timer: 1500
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
            title: 'Lancamento excluido com sucesso!'
        })
    </script>
@endif

    <div class="container">       

        <div class="row">
          <div class="col-sm-6"><h4>Entrada de Produtos</h4></div>
          <div class="col-sm-6" align='right'></div>
          
          <div class="col-sm-12">
                <form method="POST" action="@if(!@$ResultEntrada){{ route('entradaproduto.salvar') }}@else {{ route('entradaproduto.atualizar',@$ResultEntrada->id) }} @endif">
                @csrf                                                

                  <div class="row">

                      <div class="col-sm-12 p-1 ">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i
                                      class="bi bi-chat-square-text-fill"></i></span>
                              <select id="entidade_id" name="entidade_id" class="form-control" required>
                                  <option value="">Fornecedor</option>
                                  @foreach ($ResultEntidade as $key => $result)
                                      <option value="{{ $result->id }}" @if($result->id == @$ResultEntrada->entidade_id) selected @endif>{{ $result->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-4 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i
                                      class="bi bi-calendar-date"></i></span>
                              <input id="date" name="date" type="date" class="form-control" value="{{ @$ResultEntrada->date }}" required>
                          </div>
                      </div>

                      <div class="col-sm-4 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i class="bi bi-cash-coin"></i></span>
                              <input id="totalnota" name="totalnota" type="text" class="form-control"
                                  placeholder="Total da NFe" value="{{ @$ResultEntrada->total }}" onKeyUp="mascaraMoeda(this, event)"  required>
                          </div>
                      </div>

                      <div class="col-sm-4 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-upc-scan"></i>
                              </span>
                              <input id="note_number" name="note_number" type="text" class="form-control"
                                  placeholder="Nº da NFe" value="{{ @$ResultEntrada->note_number }}" >
                          </div>
                      </div>

                  </div>

                  <div class="row">
                    <div class="col-sm-12 p-1">
                        <textarea name="note" class="form-control" style="width: 100%; height:100px;" placeholder="Observação da Entrada de Produtos">{{ @$ResultEntrada->note }}</textarea>
                    </div>
                  </div>

                  <div id="financeiro" class="row">
                    <div class="col-sm-12 p-1"><strong>Movimento Financeiro</strong></div>
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
                  @if(!@$ResultEntrada)
                  <div class="row "> 
                    <div class="col-sm-12 p-1"><strong>Relação de Produtos da Entrada</strong></div> 
                      <div id="consultaProdutos" class="col-sm-5 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-search"></i> </span>                                                                
                              <select id="product_name" name="product_name" class="form-control select2" data-width="90%" >
                                  <option value="">Produto </option>
                              </select>
                          </div>                          
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i
                                      class="bi bi-braces-asterisk"></i> </span>
                              <input id="quantity" name="quantity" type="text" class="form-control"
                                  placeholder="Qtde" value="" >
                          </div>
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-cash-coin"></i>
                              </span>
                              <input id="price" name="price"  type="text" class="form-control"
                                  placeholder="R$" value="" onKeyUp="mascaraMoeda(this, event)" >
                          </div>
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-cash-coin"></i>
                              </span>
                              <input id="total" name="total" type="text" class="form-control"
                                  placeholder="R$" value="" onKeyUp="mascaraMoeda(this, event)" >
                          </div>
                      </div>                      

                      <div class="col-sm-2 p-1">
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
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i
                                      class="bi bi-braces-asterisk"></i>
                              </span>
                              <input id="qtde_quadrado" name="qtde_quadrado" type="text" class="form-control"
                                  placeholder="Qtde MT²" value="" >
                          </div>
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i
                                      class="bi bi-braces-asterisk"></i>
                              </span>
                              <input id="total_quadrado" name="total_quadrado" type="text" class="form-control"
                                  placeholder="Total MT²" value="" >
                          </div>
                      </div>
                      <div class="col-sm-1 p-1">
                        <div class="input-group">
                            <input type="button" id="add" class="btn btn-success w-100" value="[+]">
                        </div>
                    </div>

                  </div>

                  <div class="row">
                      <table class="table table-striped w-100">
                          <thead>
                              <tr>
                                  <th style="width: 20%">Produto</th>
                                  <th style="width: 10%" class="text-end">Valor</th>
                                  <th style="width: 10%" class="text-end">Qtde</th>
                                  <th style="width: 10%" class="text-end">Total</th>
                                  <th style="width: 10%" class="text-end">Largura</th>
                                  <th style="width: 10%" class="text-end">Espessura</th>
                                  <th style="width: 10%" class="text-end">Comprimento</th>
                                  <th style="width: 10%" class="text-end">Qtd M²</th>
                                  <th style="width: 10%" class="text-end">Total M²</th>
                              </tr>
                          </thead>                              
                        </table>
                        <div id="divItens" class="row"></div>
                    @else                    
                    <table class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th style="width: 20%">Produto</th>
                                <th style="width: 10%" class="text-end">Valor</th>
                                <th style="width: 10%" class="text-end">Qtde</th>
                                <th style="width: 10%" class="text-end">Total</th>
                                <th style="width: 10%" class="text-end">Largura</th>
                                <th style="width: 10%" class="text-end">Espessura</th>
                                <th style="width: 10%" class="text-end">Comprimento</th>
                                <th style="width: 10%" class="text-end">Qtd M²</th>
                                <th style="width: 10%" class="text-end">Total M²</th>
                            </tr>
                        </thead>                              
                        <tbody>
                        @foreach($ResultItensEntrada as $result)
                            <tr>
                                <td style="width: 20%">{{ $result->Product() }}</td>
                                <td style="width: 10%" class="text-end">{{ $result->price }}</td>
                                <td style="width: 10%" class="text-end">{{ $result->quantity }}</td>
                                <td style="width: 10%" class="text-end">{{ $result->total }}</td>
                                <td style="width: 10%" class="text-end">{{ $result->largura }}</td>
                                <td style="width: 10%" class="text-end">{{ $result->espessura }}</td>
                                <td style="width: 10%" class="text-end">{{ $result->comprimento }}</td>
                                <td style="width: 10%" class="text-end">{{ $result->qtde_quadrado }}</td>
                                <td style="width: 10%" class="text-end">{{ $result->total_quadrado }}</td>
                            </tr>
                        @endforeach                      
                        </tbody>                              
                      </table>
                      @endif
                  </div>
            </div>
        </div>


        <div class="row p-1">
            <div class="col-sm-6 text-start">
                <a href="{{ url('/EntradaProduto') }}"><button type="button" class="btn btn-info"><i
                    class="bi bi-reply-all-fill"></i> Voltar</button></a>
            </div>
            <div class="col-sm-6 text-end">
                <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Salvar</button>
            </div>
        </div>

    </div>

    <script>
        String.prototype.reverse = function(){
        return this.split('').reverse().join(''); 
      };
      
      $(document).ready(function() {
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
       });

        function del(codigo, product_id) {

            Swal.fire({
                title: 'Excluir?',
                text: "Esta ação vai apagar o lançamento selecionado!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '/Tabela/Deletar/' + codigo + '/' + product_id;
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

           


        //multiplica o valor pela quantidade de itens
        //resultado joga no total
        $("#price, #quantity").change(function () {     
          var product_id = $("#product_name").val();
          var quantity = $("#quantity").val();
          var price = $("#price").val();       
          
          var TotalOperacao = (quantity * price).toFixed(2);
          $("#total").val(TotalOperacao);
         
        })
        
        //preenche a 1º parcela com o valor do total da nota
        $("#totalnota").change(function () {     
          var totalnota = $("#totalnota").val();
          $("#parcela_price").val(totalnota);
         
        })

       
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
            html_itens += "<table class='table table-striped w-100' >";
            html_itens += "<tbody>";
            html_itens += "<tr>";
            html_itens += "<td colspan='9'>";
            html_itens += "<input name='product_id[]' type='hidden' value='"+ product_id + "'>";
            html_itens += "<input name='price[]' type='hidden' value='"+ price + "'>";
            html_itens += "<input name='quantity[]' type='hidden' value='"+ quantity + "'>";
            html_itens += "<input name='total[]' type='hidden' value='"+ total + "'>";
            html_itens += "<input name='largura[]' type='hidden' value='"+ largura + "'>";
            html_itens += "<input name='espessura[]' type='hidden' value='"+ espessura + "'>";
            html_itens += "<input name='comprimento[]' type='hidden' value='"+ comprimento + "'>";
            html_itens += "<input name='qtde_quadrado[]' type='hidden' value='"+ qtde_quadrado + "'>";
            html_itens += "<input name='total_quadrado[]' type='hidden' value='"+ total_quadrado + "'>";
            html_itens += "</td>";
            html_itens += "</tr>";
            html_itens += "<tr>";
            html_itens += "<td style='width: 20%'>" + product_id + "</td>";
            html_itens += "<td style='width: 10%' align='right'>" + price + "</td>";
            html_itens += "<td style='width: 10%' align='right'>" + quantity + "</td>";
            html_itens += "<td style='width: 10%' align='right'>" + total + "</td>";
            html_itens += "<td style='width: 10%' align='right'>" + largura + "</td>";
            html_itens += "<td style='width: 10%' align='right'>" + espessura + "</td>";
            html_itens += "<td style='width: 10%' align='right'>" + comprimento + "</td>";
            html_itens += "<td style='width: 10%' align='right'>" + qtde_quadrado + "</td>";
            html_itens += "<td style='width: 10%' align='right'>" + total_quadrado + "</td>";
            html_itens += "</tr>";
            html_itens += "</tbody>";
            html_itens += "</table>";

            $("#divItens").append(html_itens);
            limpa_campos();
            $("#product_name").focus(); 

        });

        function limpa_campos() {
                        $("#product_name").empty();       
                        $("#quantity").val('');
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
