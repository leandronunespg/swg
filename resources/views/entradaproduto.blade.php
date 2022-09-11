@extends('layout.app')

@section('content')

<script>
  function del(codigo) { 
    Swal.fire({
  title: 'Excluir?',
  text: "Esta ação vai apagar a Compra selecionado!",
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
    location.href = '/EntradaProduto/Deletar/' + codigo;
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
  title: 'Compra cadastrada com sucesso!'
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
  title: 'Compra alterada com sucesso!'
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
  title: 'Compra excluida com sucesso!'
})
</script>
@endif


<div class="container">

 
    

  <div class="row">
    <div class="col-sm-8">
      <h4>Relação de Compras de Produtos</h4>
    </div>
    <div class="col-sm-4 p-1 text-end">
      <a href="/EntradaProduto/Adicionar/"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Add</button></a>                      
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
             @foreach($ResultEntrada as $key => $resultado)  
              <tr>
                <td>{{ $resultado->id }}<input type="hidden" class="id_{{ $key }}" value="{{ $resultado->id }}"></td>
                <td>{{ $resultado->Entidades() }}</td>
                <td>{{ $resultado->Usuario() }}</td>
                <td>{{ number_format($resultado->total,2,',','.') }}</td>                
                <td>{{ $resultado->FormatData() }}</td>                
                <td><a href="/EntradaProduto/Editar/{{ $resultado->id }}"><i class="bi bi-pencil-square"></i></a> | 
                    <a href="javascript:del({{ $resultado->id }})"><i class="bi bi-trash" style="color:red;"></i></a> | 
                    <a href="{{ url("compra-pdf/$resultado->id") }}" target="_black"><i id="btnPrint" class="bi bi-printer btn-sm" style="color:green;"></i></a>
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

</script>

@endsection