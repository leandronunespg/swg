@extends('layout.app')

@section('content')

<script>
  function del(codigo) { 
    Swal.fire({
  title: 'Excluir?',
  text: "Esta ação vai apagar o lançamento selecionado!",
  icon: 'warning',
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
    location.href = '/Lancamentos/Deletar/' + codigo;
  }
})

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

@if(session('pay_message'))
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
  title: 'Lançamento pago com sucesso!'
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

    <!---modal filtro-->
  <div class="modal fade" id="Filtro" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Filtro</h3>
        </div>        
        <div class="modal-body">
          <form method="POST" action="{{ url("/Bancos/Filtro/") }}">
            @csrf
            <div class="row">
              <div class="col-sm-2">Banco/Caixa</div>
              <div class="col-sm-10">
                <select id="user_id" name="entidade_id" class="form-control" >
                  <option value=""></option>
                  @foreach ($ResultUser as $result)
                      <option value="{{ $result->id }}">{{ $result->name }}</option>
                  @endforeach
              </select>
              </div>
              <div class="col-sm-2">Data Inicio</div>
              <div class="col-sm-10"><input type="date" name="data_inicio" id="data_inicio" class="form-control"></div>
              <div class="col-sm-2">Data Final</div>
              <div class="col-sm-10"><input type="date" name="data_final" id="data_final" class="form-control"></div>
            </div>
         
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info" >Filtrar</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  <!----fim modal------>

     <!---modal pagamento-->
     <div class="modal fade" id="Pagamento" role="dialog">
      <div class="modal-dialog modal-lg">
        
        <div class="modal-content"> 
          <div class="modal-header">
            <h3 class="modal-title">Pagamento</h3>
          </div>       
          <div class="modal-body">
            <form method="POST" action="{{ route('pagamentos.salvar') }}">
              @csrf
              <div class="row">
                <div class="col-sm-3">Cod.:</div>
                <div class="col-sm-9"><input type="text" id="cod_pagamento" name="cod_pagamento" class="form-control" value="" readonly>
                  <input type="hidden" name="status" class="form-control" value="" readonly></div>
                <div class="col-sm-3">Data Vencimento</div>
                <div class="col-sm-9"><input type="date" id="data_vencimento" name="data_vencimento" class="form-control" value="" readonly></div>
                <div class="col-sm-3">Valor Vencimento</div>
                <div class="col-sm-9"><input type="text" id="valor_vencimento" name="valor_vencimento" class="form-control" value="" readonly></div>
                <div class="col-sm-3">Data Pagamento</div>
                <div class="col-sm-9"><input type="date" id="data_pagamento" name="data_pagamento" class="form-control" value=""></div>
                <div class="col-sm-3">Valor Pagamento</div>
                <div class="col-sm-9"><input type="text" id="valor_pagamento" name="valor_pagamento" onKeyUp="mascaraMoeda(this, event)" class="form-control" value=""></div>
              </div>           
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" >Salvar Pagamento</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    <!----fim modal------>

  <div class="row">
    <div class="col-sm-12">
      <h4>Extrato Financeiro</h4>
      <div class="row">
      <div class="col-sm-8">
        <a href="/Lancamentos/Adicionar/Dados"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Add</button></a>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Filtro"><i class="bi bi-search"></i> Filtro</button>
        
      </div>
      <div class="col-sm-1" align="right"><strong>Total</strong></div>
      <div class="col-sm-3" align="right"><h2>R${{ number_format($Total->Total,2,',','.') }}</h2></div>
    </div>

    <div class="table-responsive">
      
      <table id="datatable-buttons" class="display responsive" style="width:100%">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th>Entidade</th>                
                <th>Valor</th>
                <th>Data</th>
                <th>#</th>
              
              </tr>
            </thead>
            <tbody id="Tabela">
             @foreach($ResultBanco as $key => $resultado)  
              <tr>
                <td>{{ $resultado->id }}<input type="hidden" class="id_{{ $key }}" value="{{ $resultado->id }}"></td>
                <td>{{ $resultado->Entidades() }}</td>
                <td>{{ number_format($resultado->price,2,',','.') }}</td>                
                <td>{{ $resultado->FormatData() }}</td>                
                <td><a href="/Lancamentos/Editar/{{ $resultado->id }}"><i class="bi bi-pencil-square"></i></a> | 
                    <a href="javascript:del({{ $resultado->id }})"><i class="bi bi-trash" style="color:red;"></i></a> | 
                    <a href="#" onclick="BtPagar({{ $key }})" data-toggle="modal" data-target="#Pagamento">
                      <i class="bi bi-cash-coin text-success"></i>
                    </a>
                </td>            
              </tr>
             @endforeach
            </tbody>
        </table>
    </div>

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


  function mascaraMoeda(campo,evento){
  var tecla = (!evento) ? window.event.keyCode : evento.which;
  var valor  =  campo.value.replace(/[^\d]+/gi,'').reverse();
  var resultado  = "";
  var mascara = "########.##".reverse();
  for (var x=0, y=0; x<mascara.length && y<valor.length;) {
    if (mascara.charAt(x) != '#') {
      resultado += mascara.charAt(x);
      x++;
    } else {
      resultado += valor.charAt(y);
      y++;
      x++;
    }
  }
  campo.value = resultado.reverse();
}

 function BtPagar(key) {
    var id = $(".id_" + key).val();

    // AJAX request
    $.ajax({
        url: "/Pagamentos/" + id,
        type: 'GET',
        headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
        data: {
          id: id, 
        }, 
        dataType: "json",

        success: function(resposta) {  
          $("#cod_pagamento").val(resposta.cod_pagamento);  
          $("#data_vencimento").val(resposta.data_vencimento);  
          $("#valor_vencimento").val(resposta.valor_vencimento);  
        }

    })

}

</script>

@endsection