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
  title: 'Orçamento Gerado com Sucesso!',
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
          <div class="col-sm-8"><h4>Orçamento</h4> </div>
          <div class="col-sm-4 text-end">
            @if(isset($ResultOrcamento->id))
            <button class="btn btn-info "><a href="{{ url("orcamento-pdf/".@$ResultOrcamento->id) }}" target="_blank"><i class="bi bi-printer"></i> Imprimir</a></button>             
                @if(@$ResultOrcamento->aprovado == 'N')
                <button id="BtnModal" class="btn btn-warning">    
                    <a href="javascript:gerarPedido({{ $ResultOrcamento->id }})"><i class="bi bi-printer"></i> Gerar Pedido</a>
                </button>
                @else
                <button id="BtnModal" class="btn btn-primary"> 
                    <a href="{{ url("Pedido/Editar/".@$ResultOrcamento->id) }}"><i class="bi bi-check-circle-fill"></i> Pedido Gerado</a>
                </button>
                @endif
                @endif
          </div>
          
          <div class="col-sm-12">
                <form method="POST" action="@if(!@$ResultOrcamento){{ route('orcamento.salvar') }}@else {{ route('orcamento.atualizar',@$ResultOrcamento->id) }} @endif">
                @csrf                                                

                  <div class="row">
                    @if(@$ResultOrcamento == true)
                      <div class="col-sm-12 p-1 Orcamento">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i
                                      class="bi bi-chat-square-text-fill"></i></span>
                                      <input type="text" class="form-control" value="{{ $ResultOrcamento->id }}" readonly>
                          </div>
                      </div>
                      @endif
                      <div class="col-sm-12 p-1 Orcamento">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i
                                      class="bi bi-chat-square-text-fill"></i></span>
                              <select id="entidade_id" name="entidade_id" class="form-control" required>
                                  <option value="">Cliente</option>
                                  @foreach ($ResultEntidade as $key => $result)
                                      <option value="{{ $result->id }}" @if($result->id == @$ResultOrcamento->entidade_id) selected @endif>{{ $result->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-4 p-1 Orcamento">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i
                                      class="bi bi-calendar-date"></i></span>
                              <input id="date" name="date" type="date" class="form-control" value="@if(!@$ResultOrcamento){{ date('Y-m-d') }}@else{{ substr($ResultOrcamento->date,0,10) }}@endif" readonly>
                          </div>
                      </div>

                      <div class="col-sm-3 p-1 Orcamento">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"><i class="bi bi-cash-coin"></i></span>
                              <input id="totalnota" name="totalnota" type="text" class="form-control"
                                  placeholder="Total da NFe" value="{{ @$ResultOrcamento->total }}" onKeyUp="mascaraMoeda(this, event)" readonly>
                          </div>
                      </div>                      
                      
                      <div class="col-sm-2 p-1 Orcamento">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-upc-scan"></i>
                              </span>
                              <input id="valor_frete" name="valor_frete" type="text" class="form-control"
                                  placeholder="R$ do Frete" value="@if(!@$ResultOrcamento->valor_frete) 0 @else {{ @$ResultOrcamento->valor_frete }} @endif" onKeyUp="mascaraMoeda(this, event)" onblur="calculaTotal()">
                          </div>
                      </div>

                      <div class="col-sm-3 p-1 Orcamento">
                        <div class="input-group">
                            <span class="input-group-addon input-group-text"> <i class="bi bi-upc-scan"></i>
                            </span>
                            <input id="grand_total" name="grand_total" type="text" class="form-control"
                                placeholder="SubTotal" value="{{ number_format(@$ResultOrcamento->total + @$ResultOrcamento->valor_frete,2,'.','') }}" readonly>
                        </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="col-sm-12 p-1 Orcamento">
                        <textarea name="note" class="form-control" style="width: 100%; height:100px;" placeholder="Observação do Orçamento">{{ @$ResultOrcamento->note }}</textarea>
                    </div>
                  </div>

                 
                 
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
                                  placeholder="Qtde" value="1" >
                          </div>
                      </div>

                      <div class="col-sm-2 p-1">
                          <div class="input-group">
                              <span class="input-group-addon input-group-text"> <i class="bi bi-cash-coin"></i>
                              </span>
                              <input id="price" name="price"  type="text" class="form-control"
                                  placeholder="R$" value="" onKeyUp="mascaraMoeda(this, event)" readonly>
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
                            <input type="button" id="add" class="btn btn-success w-100" value="[+]" disabled="disabled">
                        </div>
                    </div>

                  </div>
     
                  <div class="row">
                      <table id='tableItens' class="table table-striped w-100 Orcamento">
                          <thead>
                              <tr>
                                  <th style="width: 20%">Produto</th>
                                  <th style="width: 10%" class="text-center">Valor</th>
                                  <th style="width: 10%" class="text-center">Qtde</th>
                                  <th style="width: 10%" class="text-center">Total</th>
                                  <th style="width: 10%" class="text-center">Largura</th>
                                  <th style="width: 10%" class="text-center">Espessura</th>
                                  <th style="width: 10%" class="text-center">Comprimento</th>
                                  <th style="width: 10%" class="text-center">Qtd M²</th>
                                  <th style="width: 5%" class="text-center">Total M²</th>
                                  <th style="width: 5%" class="text-center">#</th>
                              </tr>
                              <tbody id="divItens">
                              @if($ResultOrcamento == true)
                              @foreach($ResultItensOrcamento as $result)
                                <tr>
                                    <td style="width: 20%">{{ $result->Product() }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->unit_price }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->quantity }}</td>
                                    <td style="width: 10%" class="text-center vlr">{{ $result->subtotal }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->largura }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->espessura }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->comprimento }}</td>
                                    <td style="width: 10%" class="text-center">{{ $result->qtde_quadrado }}</td>
                                    <td style="width: 5%" class="text-center">{{ $result->total_quadrado }}</td>
                                    <td style="width: 5%" class="text-center">
                                        <a href="javascript:del({{ $result->id }},{{ $result->orcamento_id }} )"><button type="button" class="btn btn-danger btn-sm">[-]</button></a>
                                    </td>
                                </tr>
                            @endforeach   
                            @endif
                              </tbody>
                          </thead>                              
                        </table>
                  </div>
                 

                  <div id="entrega" class="row Orcamento">
                    <div class="Orcamento" style="display: none">Teste para impressão</div>
                    <div class="col-sm-12 p-1"><strong>Dados para entrega</strong></div>
                    <div class="col-sm-6 p-1">Endereço<br>
                        <input type="text" id="delivery_address" name="delivery_address" class="form-control" value="{{ @$ResultOrcamento->delivery_address }}" >
                      </div>
                      <div class="col-sm-1 p-1">Número<br>
                          <input type="text" id="delivery_number" name="delivery_number" class="form-control" value="{{ @$ResultOrcamento->delivery_number}}">
                      </div>
                      <div class="col-sm-2 p-1">CEP<br>
                          <input type="text" id="delivery_zip_code" name="delivery_zip_code" class="form-control" value="{{ @$ResultOrcamento->delivery_zip_code}}">
                      </div>
                      <div class="col-sm-3 p-1">Bairro<br>
                          <input type="text" id="delivery_district" name="delivery_district" class="form-control" value="{{ @$ResultOrcamento->delivery_district}}">
                      </div>
                      <div class="col-sm-5 p-1">Cidade<br>
                          <input type="text" id="delivery_city" name="delivery_city" class="form-control" value="{{ @$ResultOrcamento->delivery_city }}">
                      </div>
                      <div class="col-sm-1 p-1">Estado<br>
                          <input type="text" id="delivery_state" name="delivery_state" class="form-control" value="{{ @$ResultOrcamento->delivery_state }}">
                      </div>

                      <div class="col-sm-3 p-1">Telefone<br>
                          <input type="text" id="delivery_fone" name="delivery_fone" class="form-control" value="{{ @$ResultOrcamento->delivery_fone }}">
                      </div>
                      <div class="col-sm-3 p-1">Telefone<br>
                          <input type="text" id="delivery_fone2" name="delivery_fone2" class="form-control" value="{{ @$ResultOrcamento->delivery_fone2 }}">
                      </div>
                      
                    
                   
                  </div>
            </div>
        </div>

        <hr>
        <div class="row p-1">
            <div class="col-sm-12 text-end">
                <a href="{{ url('/Orcamento') }}"><button type="button" class="btn btn-info"><i
                            class="bi bi-reply-all-fill"></i> Voltar</button></a>
                <button type="submit" id="salvar" class="btn btn-success" disabled="disabled"><i class="bi bi-plus-circle-fill"></i> Salvar</button> 
               
               
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


    $('#BtnPrint').on("click", function () {
      $('.Orcamento').printThis({
        importCSS: true,
        header: "<h2>Orçamento</h2>",
        base: "http://www.swgsistemas.com.br/"
      });
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
    
               

      if($('#entidade_id').val() == ''){
        $('#entidade_id ').on('input change', function () {
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
    

        function del(codigo, orcamento_id) {

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
                    location.href = '/ItemOrcamento/Deletar/' + codigo + '/' + orcamento_id;                    
                }
            })
        }
       
        function gerarPedido(codigo, orcamento_id) {

            Swal.fire({
                title: 'Gerar Pedido de Venda?',
                text: "Esta ação vai gerar um pedido de venda, com os dados informados neste orçamento!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, gerar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '/GerarPedido/' + codigo + '/' + orcamento_id;                    
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
            var entidadeorcamento = $('#entidade_id').val();           
       

        // AJAX request
         $.ajax({
            url: "/ConsultaValorProduto/" + codProduto[0],
            type: 'GET',
            // headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
            data: {
            id: id, 
            identidade: entidadeorcamento, 
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
