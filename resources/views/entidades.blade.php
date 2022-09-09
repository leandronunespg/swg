@extends('layout.app')

@section('content')
    
<script>
 function del(codigo) {  
    if (confirm('Excluir?')) {  
        location.href = '/Entidades/Deletar/' + codigo;
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
  title: 'Parceiro de Negocios cadastrado com sucesso!'
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
  title: 'Parceiro de Negocios alterado com sucesso!'
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
  title: 'Parceiros de Negócio excluido com sucesso!'
})
</script>
@endif
  
<div class="container">
  <div class="row">
    <div class="col-sm-8">
      <h4>Parceiros de Negócio</h4>
    </div>
    <div class="col-sm-4 text-end ">
      <a href="/Entidades/Adicionar/"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Add</button></a><br>
    </div>
        <table id="datatable-buttons" class="display responsive" style="width:100%">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th>Tipo</th>
                <th>Nome</th>
                <th>Razão Social</th>
                <th>Telefone</th>
                <th>Telefone</th>
                <th width="5%">Funcões</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ResultEntidades as $resultado)  
              <tr>
                <td>{{ $resultado->id }}</td>
                <td>{{ $resultado->type }}</td>
                <td>{{ $resultado->name }}</td>
                <td>{{ $resultado->razao }}</td>
                <td>{{ $resultado->fone }}</td>
                <td>{{ $resultado->fone2 }}</td>        
                <td><a href="/Entidades/Editar/{{ $resultado->id }}"><i class="bi bi-pencil-square"></i></a> | <a href="javascript:del({{ $resultado->id }})"><i class="bi bi-trash" style="color:red;"></i></a></td>
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