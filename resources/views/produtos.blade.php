@extends('layout.app')

@section('content')
    
<script>
 function del(codigo) {  
    if (confirm('Excluir?')) {  
        location.href = '/Produtos/Deletar/' + codigo;
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
    

<div class="container">
  <div class="row">
    <div class="col-sm-11"> <h4>Produtos</h4></div>
    <div class="col-sm-1 p-1 text-end"> <a href="/Produtos/Adicionar/"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Add</button></a></div>
      
        <table id="datatable-buttons" class="display responsive" style="width:100%">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th width="15%">Categoria</th>
                <th>Descrição</th>                
                <th>Unidade</th>
                <th>Quantidade</th>
                <th>NCM</th>
                <th width="5%">Funcões</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ResultProdutos as $key => $resultado)  
              <tr>
                <td>{{ $resultado->id }}</td>
                <td>{{ @$resultado->FormatCategoria($resultado->id) }}</td>
                <td>
                  <button class="btn btn-info link-popover" data-popover="pp{{ $resultado->id }}"><i class="bi bi-cash-coin"></i></button>

                  <div id="pp{{ $resultado->id }}" style="display: none;">
                    <div class="row">
                      <strong>Tabela de Preços</strong><br/>
                      @foreach($TabelaPreco["Items"][$key] as $resultadoTabela)                             
                        <div class="col-sm-8 border">{{ $resultadoTabela->FormatTabela() }}</div> 
                        <div class="col-sm-4 border">{{ $resultadoTabela["price"] }}</div> 
                      @endforeach
                    </div>
                  </div>
                    
                  
                 {{ $resultado->name }}</td>                
                <td>{{ $resultado->unidade_comercial }}</td>
                <td> 
                  @foreach($TabelaEstoque["Items"][$key] as $resultadoEstoque)                                              
                        {{ $resultadoEstoque["SaldoAtual"] }} 
                  @endforeach
                </td>
                <td>{{ $resultado->ncm }}</td>        
                <td><a href="/Produtos/Editar/{{ $resultado->id }}"><i class="bi bi-pencil-square"></i></a> | <a href="javascript:del({{ $resultado->id }})"><i class="bi bi-trash" style="color:red;"></i></a></td>
              </tr>
             @endforeach 
            </tbody>
          </table>

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

$(function(){
    $("[data-toggle=popover]").popover();
    $(".link-popover").popover({
        html : true, 
        content: function() {
          let id = $(this).data('popover');
          return $('#' + id).html();
        }
    });
});
</script>
@endsection