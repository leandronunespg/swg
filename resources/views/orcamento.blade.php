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
  {{-- <div class="modal fade" id="Filtro" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Filtro</h3>
        </div>        
        <div class="modal-body">
          <form method="GET" action="{{ url("/Lancamentos/Filtro/$status") }}">
            @csrf
            <div class="row">
              <div class="col-sm-2">Usuário</div>
              <div class="col-sm-10">
                <select id="user_id" name="user_id" class="form-control" >
                  <option value=""></option>
                  @foreach ($ResultUser as $result)
                      <option value="{{ $result->id }}">{{ $result->name }}</option>
                  @endforeach
              </select>
              </div>
              <div class="col-sm-2">Data Inicio</div>
              <div class="col-sm-10"><input type="date" name="data_inicio" id="data_inicio" class="form-control" value="{{ $data_inicio }}"></div>
              <div class="col-sm-2">Data Final</div>
              <div class="col-sm-10"><input type="date" name="data_final" id="data_final" class="form-control" value="{{ $data_final }}"></div>
              <div class="col-sm-2">Situação</div>
              <div class="col-sm-10">
                <select id="status" name="status" class="form-control" >
                  <option value=""></option>                  
                      <option value="A" @if($status == 'A') selected @endif>Aberto</option>             
                      <option value="P" @if($status == 'P') selected @endif>Pago</option>
              </select>
              </div>
            </div>
         
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info" >Filtrar</button>
        </div>
      </form>
      </div>
    </div>
  </div> --}}
  <!----fim modal------>

    

  <div class="row">
    <div class="col-sm-8">
      <h4>Relação de Orçamentos</h4>
    </div>
    <div class="col-sm-4 p-1 text-end">
      <a href="/OrcamentoAdd/Adicionar"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Add</button></a>                      
    </div>
  
    <div class="table-responsive">
      
      <table id="datatable-buttons" class="display responsive" style="width:100%">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th>Parceiro de Negócio</th>
                <th>Usuário</th>
                <th>Total</th>
                <th>Data</th>
                <th>Funções</th>
              </tr>
            </thead>
            <tbody id="Tabela">
             @foreach($ResultOrcamento as $key => $resultado)  
              <tr>
                <td>{{ $resultado->id }}<input type="hidden" class="id_{{ $key }}" value="{{ $resultado->id }}"></td>
                <td>{{ $resultado->Entidades() }}</td>
                <td>{{ $resultado->Usuario() }}</td>
                <td>{{ number_format($resultado->total,2,',','.') }}</td>                
                <td>{{ $resultado->FormatData() }}</td>                
                <td><div class="btn-group" role="group" aria-label="Basic example">
                    <a href="/Orcamento/Editar/{{ $resultado->id }}"><i class="bi bi-pencil-square btn-sm"></i></a> |
                    <a href="javascript:del({{ $resultado->id }})"><i class="bi bi-trash btn-sm" style="color:red;"></i></a> |
                    <a href="{{ url("orcamento-pdf/$resultado->id") }}" target="_black"><i id="btnPrint" class="bi bi-printer btn-sm" style="color:green;"></i></a>
                    </div>
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
  
  $("#btnPrint").on("click", function() {                
                $(".printable").empty();
                $(".printable").html($("#ModalPrint").html());
                $(".printable #btnPrint").remove();
                $(".printable #TituloModal").remove();
                $(".printable #divmail").remove();
                $(".printable").printThis();                
            });


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

</script>

@endsection