@extends('layout.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Categoria de Produtos</h4>      
      <form method="POST" action="@if(!@$ResultCategorias){{ route('categorias.salvar') }} @else {{ route('categorias.atualizar',@$ResultCategorias->id) }} @endif">
        @csrf
        <table class="table">                                          
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text "><i class="bi bi-people-fill"></i></span>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Nome da Categoria" value="{{ @$ResultCategorias->name }}" required>
                    </div>
                 </td>
              </tr>
              <tr>
                <td> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text "><i class="bi bi-people-fill"></i></span>
                    <input id="code" name="code" type="text" class="form-control" required value="{{ @$ResultCategorias->code }}" placeholder="@if(!@$ResultCategorias->id) {{ $ResultCategoriasCode->code+1 }} @endif">
                    </div>
                 </td>
                <td> 
                    <div class="input-group">                  
                      <p class="fs-5">Código para tabelas de vendas</p> 
                    </div>
                 </td>
              </tr>
              <tr>
                <td class="text-start"><a href="{{ url('/Categorias') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a></td>
                <td class="text-end"><button type="submit" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Salvar</button></td>
            </tr>            
            <tbody>


            </table>
        </form>
  </div>
  </div>
</div>
@endsection
