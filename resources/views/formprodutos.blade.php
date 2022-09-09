@extends('layout.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

@if(session('deleted_message'))
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
  title: 'Lancamento excluido com sucesso!'
})
</script>
@endif

<div class="container">
{{-- modal para cadastro de tabela de preços --}}
<div class="modal fade" id="TabelaDiv">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
   <form action="" method="post">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tabela de Preço</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
       <div class="row">
                
        <div class="col-sm-12 p-1">
           <div class="input-group text-start">
             <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
             <input type="text" class="form-control" value="{{ @$ResultProdutos->name }}" disabled>
            </div> 
        </div>
          
        <div class="col-sm-12 p-1 ">
            <div class="input-group">
              <span class="input-group-addon input-group-text"><i class="bi bi-chat-square-text-fill"></i></span>
              <select id="tipoentidade_id" name="tipoentidade_id" class="form-control" required>
                  <option value="">Tipo de Tabela</option>
                  @foreach($ResultTipoEntidades as $result)
                  <option value="{{ @$result->code }}">{{ @$result->name }}</option>
                  @endforeach
              </select>
              </div>              
        </div> 
        
        <div class="col-sm-12 p-1">
          <div class="input-group text-start">
          <span class="input-group-addon input-group-text"><i class="bi bi-cash-coin"></i></span>
          <input id="product_id" name="product_id" type="hidden" class="form-control" value="{{ @$ResultProdutos->id }}">
          <input id="PriceTabela" name="PriceTabela" type="text" onKeyUp="mascaraMoeda(this, event)" class="form-control" placeholder="Valor" value="">
          </div> 
        </div>
       
        {{-- <div class="col-sm-2 p-1">
          <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="PercentualTabela" value="1">
            <label class="form-check-label" for="PercentualTabela">Percentual</label>
          </div>
        </div> --}}

        <div class="col-sm-12 text-end">
          <button type="button" id="BtTabela" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Salvar</button>
        </div>
       
        @if($ResultTabelas == true)
        <div class="col-sm-12 p-1">
          <table class="table table-striped">
            <thead>
              <th> TABELA </th>
              <th> VALOR </th>
            </thead>
            <tbody>
            @foreach($ResultTabelas as $key => $result)
              <tr>
                <td>{{ $result->FormatTabela($result->tipoentidade_id) }}</td>
                <td>{{ $result->price }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>      
        </div>  
        @endif

       </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

      </form>
    </div>
  </div>
</div>
{{-- fim da modal de tabela de preços  --}}

  <div class="row">
    <div class="col-sm-12">
      <h4>Produtos</h4>      
      <form method="POST" action="@if(!@$ResultProdutos){{ route('produtos.salvar') }}@else {{ route('produtos.atualizar',@$ResultProdutos->id) }} @endif">
        @csrf

        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#DadosGerais">Dados Gerais</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#DadosExtras">Dados Fiscais</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#TabelaPrecos">Tabela de Preços</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#HistoricoVendas">Hitórico de Vendas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#HistoricoFinanceiro">Hitórico de Compra</a>
          </li>
        </ul>
      
        <!-- Tab panes -->
        <div class="tab-content">
          <div id="DadosGerais" class="container tab-pane active"><br>
            <div class="row">
           
              <div class="col-sm-12 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-chat-square-text-fill"></i></span>
                  <select id="category_id" name="category_id" class="form-control" required>
                      <option value="">Categoria</option>
                      @foreach($ResultCategorias as $result)
                      <option value="{{ $result->id }}" @if(@$ResultProdutos->category_id == $result->id) selected @endif>{{ $result->name }}</option>
                      @endforeach
                  </select>
                  </div>              
              </div> 

              <div class="col-sm-2 p-1">
                    <div class="input-group">
                      <span class="input-group-addon input-group-text"><i class="bi bi-upc-scan"></i></span>
                      <input id="code" name="code" type="text" class="form-control" placeholder="Código de barras" value="{{ @$ResultProdutos->code }}">
                    </div>
              </div>
              <div class="col-sm-8 p-1">
                    <div class="input-group">
                      <span class="input-group-addon input-group-text"><i class="bi bi-box-seam"></i></span>
                      <input id="name" name="name" type="text" class="form-control" placeholder="Nome Produto" value="{{ @$ResultProdutos->name }}" required>
                    </div>
              </div>
              {{-- <div class="col-sm-2 p-1">
                  <div class="input-group">
                      <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                      <input id="price" name="price" type="text" class="form-control" placeholder="R$" value="{{ @$ResultProdutos->price }}" required>
                  </div>
              </div> --}}
              <div class="col-sm-2 p-1">
                  <div class="input-group">
                      <span class="input-group-addon input-group-text"> UN </span>
                      <input id="unidade_comercial" name="unidade_comercial" type="text" class="form-control" placeholder="UN" value="{{ @$ResultProdutos->unidade_comercial }}" required>
                  </div>
              </div>
              {{-- <div class="col-sm-3 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-cash-coin"></i></span>
                  <input id="cost" name="cost" type="number" class="form-control" placeholder="R$" value="{{ @$ResultProdutos->cost }}">
                  </div>
              </div> --}}
             
              <div class="col-sm-3 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-file-plus"></i></span>
                  <input id="quantity" name="quantity" type="number" readonly class="form-control" placeholder="Quantidade" value="{{ @$ResultEstoque->SaldoAtual }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-exclamation-octagon"></i></span>
                  <input id="alert_quantity" name="alert_quantity" type="number" class="form-control" placeholder="Quantidade Mínima" value="{{ @$ResultProdutos->alert_quantity }}">
                </div>
              </div>
              <div class="col-sm-2 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text">NCM</span>
                  <input id="ncm" name="ncm" type="number" class="form-control" placeholder="NCM" value="{{ @$ResultProdutos->ncm }}">
                  </div>
              </div>
              
                <div class="col-sm-12 p-1">
                  <table class="table">
                    <thead>
                      <th> TABELA </th>
                      <th> VALOR </th>
                    </thead>
                    <tbody>
                    @if($ResultTabelas == true)  
                    @foreach($ResultTabelas as $key => $result)
                    @if($result->tipoentidade_id == '1')
                      <tr>
                        <td> 
                          <div class="input-group">
                             <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                             <input type="text" class="form-control" value="{{ $result->FormatTabela($result->tipoentidade_id) }}" readonly>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <span class="input-group-addon input-group-text"><i class="bi bi-cash-coin"></i></span>
                            <input type="text" class="form-control" value="{{ $result->price }}" readonly>
                          </div>                          
                        </td>
                      </tr>
                      @endif
                      @endforeach
                      @endif
                    </tbody>
                  </table>              
                </div>  
   
              @if(@$ResultProdutos == true)
              <div class="col-sm-12 p-1 ">
                <div class="input-group">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#TabelaDiv">
                    Adicionar Nova Tabela de Preço
                  </button>
                  </div>
              </div>
              @endif
                      
              
            </div>               
          </div>



          <div id="DadosExtras" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-12 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="natureza_operacao" name="natureza_operacao" type="text" class="form-control" placeholder="Natureza de Operação" value="@if(!@@$ResultProdutos->natureza_operacao) {{ "VENDA AO CONSUMIDOR" }} @else {{ @@$ResultProdutos->natureza_operacao }} @endif">
                </div>
              </div>  
              <div class="col-sm-2 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text">102</span>
                  <input id="icms_situacao_tributaria" name="icms_situacao_tributaria" type="text" class="form-control" placeholder="ST-ICMS" value="{{ @@$ResultProdutos->icms_situacao_tributaria }}">
                  </div>
              </div>  
              <div class="col-sm-2 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text">0</span>
                  <input id="icms_origem" name="icms_origem" type="text" class="form-control" placeholder="ICMS Origem" value="{{ @@$ResultProdutos->icms_origem }}">
                  </div>
              </div>  
              
              <div class="col-sm-2 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text">0</span>
                  <input id="pis_situacao_tributaria" name="pis_situacao_tributaria" type="text" class="form-control" placeholder="ST PIS " value="{{ @@$ResultProdutos->pis_situacao_tributaria }}">
                  </div>
              </div>  
              <div class="col-sm-2 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text">0</span>
                  <input id="cofins_situacao_tributaria" name="cofins_situacao_tributaria" type="text" class="form-control" placeholder="ST Cofins" value="{{ @@$ResultProdutos->cofins_situacao_tributaria }}">
                  </div>
              </div>  
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="cfop" name="cfop" type="text" class="form-control" placeholder="CFOP - 5102 dentro do estado, 6102 fora!" value="{{ @@$ResultProdutos->cfop }}">
                  </div>
              </div>   

            </div>
          </div>
          
          <div id="TabelaPrecos" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-12 p-1">
                <table class="table table-striped">
                  <thead>
                    <th style="width: 1%"> # </th>
                    <th> TABELA </th>
                    <th style="width: 6%"> VALOR </th>
                    <th style="width: 1%"> # </th>
                  </thead>
                  <tbody>
                  @if($ResultTabelas == true)
                  @foreach($ResultTabelas as $key => $result)
                    <tr>
                      <td><i class="bi bi-arrow-right-square"></i></td>
                      <td>{{ $result->FormatTabela($result->tipoentidade_id) }}</td>
                      <td>{{ $result->price }}</td>
                      <td><a href="javascript:del({{ $result->id }},{{ $result->product_id }} )"><i class="bi bi-trash3"></i></a></td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                </table>
            
              </div>    

            </div>
          </div>


         

          <div id="HistoricoVendas" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-12 p-1 card">
                Nenhum Registro
              </div>
            </div>
          </div>
         
          <div id="HistoricoFinanceiro" class="container tab-pane fade"><br>
            <div class="row">
                <div class="col-sm-12 p-1 card">
                  Nenhum Registro
                </div>
              </div>
          </div>

        </div>
       
        <div class="row p-1">
          <div class="col-sm-12" align="right">
            <a href="{{ url('/Produtos') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a>
            <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Salvar</button>
          </div>
        </div>
        
        </form>
  </div>
  </div>
</div>

<script>

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
      // Swal.fire(
      //   'Deleted!',
      //   'Your file has been deleted.',
      //   'success'
      // )
      location.href = '/Tabela/Deletar/' + codigo + '/' + product_id;
    }
  })
}



$('#BtTabela').click(function() {

      var tipoentidade_id    = $("#tipoentidade_id").val();
      var product_id         = $("#product_id").val();            
      var PriceTabela        = $("#PriceTabela").val();
      // var PercentualTabela   = $("#PercentualTabela").val();
  
      // AJAX request
      $.ajax({
          url: '/Produtos/Tabela/Salvar/',
          type: 'post',
          headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },

          data: {
              tipoentidade_id: tipoentidade_id,
              product_id: product_id,
              PriceTabela: PriceTabela
              // PercentualTabela: PercentualTabela
          },

          success: function(response) {
              Swal.fire({
                  text: "Tabela Gravada com Sucesso!",
                  icon: "success",
                  showConfirmButton: !1,
              });

              $("#TabelaDiv").modal("hide");

             // refresh  
              setTimeout(function() {
                  window.location.reload(1);
              }, 150);

              $("#Loading").html("");

          }
      });

  });
  </script>

@endsection

