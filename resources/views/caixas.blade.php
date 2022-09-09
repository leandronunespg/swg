@extends('layout.app')

@section('content')
    
<script>
 function del(codigo) {  
    if (confirm('Excluir?')) {  
        location.href = '/Caixas/Deletar/' + codigo;
    }
}
</script>

@if(session('success_message'))
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
  title: 'Lançamento cadastrado com sucesso!'
})
</script>
@endif

@if(session('update_message'))
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
  title: 'Lançamento alterado com sucesso!'
})
</script>
@endif

<form action="{{ route('caixa.index') }}" method="get">

  <div class="container">
  <div class="row">
    <div class="col-sm-11"> <h4>Relação de Lançamentos Caixa</h4></div>   
    
        <div class="col-sm-12 p-1">
          <div class="input-group">
            <span class="input-group-addon input-group-text"><i class="bi bi-person-fill"></i></span>
            <select id="banco_id" name="banco_id" class="form-control">
                <option value="">Banco</option>
                @foreach ($ResultBanco as $result)
                    <option value="{{ $result->id }}" @if(@$_REQUEST["banco_id"] == $result->id) selected @endif>{{ $result->name }}</option>
                @endforeach
            </select>
          </div>
        </div>

        <div class="col-sm-2 p-2">
          <div class="input-group">
            <span class="input-group-addon input-group-text "><i class="bi bi-people-fill"></i></span>
            <input id="date_inicio" name="date_inicio" type="date" class="form-control form-control-sm" value="{{ @$_REQUEST["date_inicio"] }}" required>
            </div>
        </div>  

        <div class="col-sm-2 p-2">
          <div class="input-group">
            <span class="input-group-addon input-group-text sm"><i class="bi bi-people-fill"></i></span>
            <input id="date_final" name="date_final" type="date" class="form-control form-control-sm" value="{{ @$_REQUEST["date_final"] }}" required >
            </div>
        </div> 

        <div class="col-sm-2 p-2">
          <div class="input-group">
            <span class="input-group-addon input-group-text sm"><i class="bi bi-people-fill"></i></span>
            <input id="pedido" name="pedido" type="number" class="form-control form-control-sm" placeholder="Nº Pedido"  value="{{ @$_REQUEST["pedido"] }}" >
            </div>
        </div> 

        <div class="col-sm-1 p-2">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="check_entrada" name="check_entrada" @if(@$_REQUEST["check_entrada"] == true) checked @endif>
            <label class="form-check-label" for="check_entrada">Entrada</label>
          </div>
        </div> 

        <div class="col-sm-5 p-2">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="check_saida" name="check_saida" @if(@$_REQUEST["check_saida"] == true) checked @endif>
            <label class="form-check-label" for="check_saida">Saída</label>
          </div>
        </div> 
        
        <div class="col-sm-3 p-2">
          <div class="input-group">
            <span class="input-group-addon input-group-text"><i class="bi bi-person-fill"></i></span>
            <select id="entidade_id" name="entidade_id" class="form-control">
                <option value="">Entidade</option>
                @foreach ($ResultEntidade as $result)
                    <option value="{{ $result->id }}" @if(@$_REQUEST["entidade_id"] == $result->id) selected @endif>{{ $result->name }}</option>
                @endforeach
            </select>
          </div>
        </div>         
       
       {{--  <div class="col-sm-2 p-2">
          <div class="input-group">
            <span class="input-group-addon input-group-text"><i class="bi bi-person-fill"></i></span>
            <select id="banco_id" name="banco_id" class="form-control">
                <option value="">Banco</option>
                @foreach ($ResultBanco as $result)
                    <option value="{{ $result->id }}" @if(@$_REQUEST["banco_id"] == $result->id) selected @endif>{{ $result->name }}</option>
                @endforeach
            </select>
          </div>
        </div>   --}}       

        <div class="col-sm-2 p-2">
          <div class="input-group">
            <span class="input-group-addon input-group-text"><i class="bi bi-arrow-90deg-down"></i></span>
            <select id="centrocusto_id" name="centrocusto_id" class="form-control" >
                <option value="">Centro de Custo</option>
                @foreach ($ResultCentroCusto as $result)
                    <option value="{{ $result->id }}" @if(@$_REQUEST["centrocusto_id"] == $result->id) selected @endif>{{ $result->name }}</option>
                @endforeach
            </select>
          </div>
        </div> 
        
        <div class="col-sm-2 p-2">
          <div class="input-group">
            <span class="input-group-addon input-group-text"><i class="bi bi-arrow-90deg-right"></i></span>                                  
            <select id="historico_id" name="historico_id" class="form-control">
                <option value="">Histórico</option>
                
            </select>
          </div>
        </div> 

        <div class="col-sm-3 p-2">
          <button type="submit" class="btn btn-info">
            <i class="bi bi-pencil-square"></i> Filtrar
          </button>
        </div>

    

    <table id="datatable-buttons" class="display responsive" style="width:100%">
            <thead>
                <tr>
                  <th width="5%">#</th>
                  <th>Banco</th>
                  <th>Parceiro de Negócio</th>
                  <th>Pedido</th>
                  {{-- <th>Lançamento</th> --}}
                  <th>Centro de Custo</th>
                  <th>Histórico</th>
                  <th>Valor</th>
                  <th>Data</th>
                  <th>Usuário</th>                 
                </tr>
            </thead>
            <tbody>
              @foreach($ResultCaixa as $resultado)  
                <tr @if($resultado->price < 0){ echo class='text-danger'; } @endif>
                  <td>{{ $resultado->id }}</td>
                  <td>{{ @$resultado->Banco() }}</td>
                  <td>{{ @$resultado->Entidade() }}</td>
                  <td>{{ @$resultado->pedido_id }}</td>
                  {{-- <td>{{ @$resultado->lancamento_id }}</td> --}}
                  <td>{{ $resultado->CentroCusto->name }}</td>
                  <td>{{ @$resultado->Historico() }}</td>
                  <td>{{ $resultado->price }}  </td>
                  <td>{{ Carbon\Carbon::now()->parse($resultado->date)->format('d/m/Y'); }}</td>        
                  <td>{{ @$resultado->User() }}</td>                         
                </tr>               
             @endforeach
            </tbody> 
            <tfoot class="table"> 
                <tr>
                  <td width="5%">#</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="text-end">
                    <span class="fs-7 fw-bold">Entradas</span><br>
                    <span class="fs-7 fw-bold text-danger">Saídas</span><br>
                    <span class="fs-7 fw-bold">Total</span>
                  </td>
                  <td style="width: 100px;">
                    <span class="fs-7 fw-bold">R$ {{ $TotalEntrada }} </span><br>
                    <span class="fs-7 fw-bold text-danger">R$ {{ $TotalSaida }} </span><br>
                    <span class="fs-7 fw-bold">R$ {{ $TotalCaixa }}</span>
                  </td>          
                  <td></td>
                  <td></td>
                </tr>               
            </tfoot>
            
    </table>       
  </div>
</div>
</form>
<script>
  String.prototype.reverse = function(){
  return this.split('').reverse().join(''); 
};

$(document).ready(function() {
      var table = $('#datatable-buttons').DataTable({
               destroy: true,
               responsive:true,  
               dom: 'Bflrtip',                           
               buttons: [{
                          extend: 'print',
                          footer: true,
                          className: 'green glyphicon glyphicon-print',
                          text: 'Print',
                          title: ' '
                        }],                   
               searching: true,                    
               language: {
                   url: '{{ URL::asset('DataTables-1.12.1/pt-BR.json')}}'
               },
               initComplete: function () {
                   setTimeout( function () {
                       table.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
                   }, 10 );
               }
      })
});




$(document).ready(function() {
        $('#centrocusto_id').change(function() {
            let centrocusto_id = $('#centrocusto_id').val(); //Pegando o id do centro de custo
            $.ajax({
                url: "/ConsultaHistorico/" + centrocusto_id, //consultando na minha rota
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") //token obrigatório
                },
                data: {
                    centrocusto_id: centrocusto_id, //variável do campo centro de custo
                },
                success: function(resposta) {    //retorno da resposta da minha rota                    
                        var ItensOptions = [];
                        $.each(resposta, function(k, v) {//loop para criar os registros
                            ItensOptions += "<option value='"+ v["id"] +"'>"+ v["name"] +"</option>";//option com o resultado da consulta
                        });
                        $("#historico_id").html(ItensOptions);//combo box onde adicionará o resultado dos dados
                },
                error: function(resposta) {
                    console.log("Deu errado!");
                    Vazio = "<option value=''>Histórico</option>";//ao clicar no label histórico
                    $("#historico_id").html(Vazio);//compo box onde adicionará o resultado dos dados
                },
            });


        });
    });
</script>


@endsection

