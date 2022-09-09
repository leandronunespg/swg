@extends('layout.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Tipo de Parceiro de Negócio</h4>   
      <form method="POST" action="@if(!@$ResultTipoEntidade){{ route('tipoentidade.salvar') }} @else {{ route('tipoentidade.atualizar',@$ResultTipoEntidade->id) }} @endif">
        @csrf
        <table class="table">                            
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text "><i class="bi bi-people-fill"></i></span>
                    <input id="name" name="name" type="text" class="form-control" value="{{ @$ResultTipoEntidade->name }}" placeholder="Nome" required>
                    </div>
                 </td>
              </tr>
             
              <tr>
                <td> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text "><i class="bi bi-people-fill"></i></span>
                    <input id="code" name="code" type="text" class="form-control" value="{{ @$ResultTipoEntidade->code }}" placeholder="{{ $ResultTipoEntidadeCode->code+1 }}">
                    </div>
                 </td>
                <td> 
                    <div class="input-group">                  
                      <p class="fs-5">Código para tabelas de vendas</p> 
                    </div>
                 </td>
              </tr>
             
              <tr>
                <td class="text-start"><a href="{{ url('/TipoEntidade') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a></td>
                <td class="text-end"><button type="submit" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Salvar</button></td>
            </tr>            
            <tbody>


            </table>
        </form>
  </div>
  </div>
</div>
@endsection
