@extends('layout.app')

@section('content')

<script>
  function del(codigo) { 
    Swal.fire({
  title: 'Excluir?',
  text: "Esta ação vai apagar o Histórico selecionado!",
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
    location.href = '/Historico/Deletar/' + codigo;
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
  title: 'Histórico cadastrada com sucesso!'
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
  title: 'Histórico excluido com sucesso!'
})
</script>
@endif

  
<div class="container">
  <div class="row">
    <div class="col-sm-8">
      <h4>Históricos</h4>
    </div>
    <div class="col-sm-4 text-end">
      <a href="/Historico/Adicionar/"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Add</button></a>
    </div>
    <table id="datatable-buttons" class="display responsive" style="width:100%">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th>Nome</th>
                <th>Centro de Custo</th>
                <th width="5%">Funcões</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ResultHistorico as $resultado)  
              <tr>
                <td>{{ $resultado->id }}</td>
                <td>{{ $resultado->name }}</td>
                <td>{{ @$resultado->CentroCusto() }}</td>                
                <td><a href="/Historico/Editar/{{ $resultado->id }}"><i class="bi bi-pencil-square"></i></a> | <a href="javascript:del({{ $resultado->id }})"><i class="bi bi-trash" style="color:red;"></i></a></td>
              </tr>
             @endforeach 
            </tbody>
          </table>

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
      })
});

</script>
@endsection
