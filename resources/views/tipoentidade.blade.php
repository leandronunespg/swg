@extends('layout.app')

@section('content')
<script>
 function del(codigo) {  
    if (confirm('Excluir?')) {  
        location.href = '/TipoEntidade/Deletar/' + codigo;
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
  title: 'Tipo Parceiro de Negócio cadastrado com sucesso!'
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
  title: 'Tipo Parceiro de Negócio alterado com sucesso!'
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
  <div class="row">
    <div class="col-sm-11"> <h4>Tipo Entidades</h4></div>
    <div class="col-sm-1 p-1 text-end" ><a href="/TipoEntidade/Adicionar/"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Add</button></a></div>        
      <table id="datatable-buttons" class="display responsive" style="width:100%">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th>Nome</th>
                <th width="5%">Funcões</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ResultTipoEntidade as $resultado)  
              <tr>
                <td>{{ $resultado->id }}</td>
                <td>{{ $resultado->name }}</td>               
                <td><a href="/TipoEntidade/Editar/{{ $resultado->id }}"><i class="bi bi-pencil-square"></i></a> | <a href="javascript:del({{ $resultado->id }})"><i class="bi bi-trash" style="color:red;"></i></a></td>
              </tr>
             @endforeach 
            </tbody>
          </table>
  </div>
</div>


<script>
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
