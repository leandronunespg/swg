@extends('layout.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Entidades</h4>
      
      <form method="POST" action="{{ route('entidades.atualizar',$ResultEntidades[0]['id']) }}">
        @csrf
        <table class="table">                            
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text"><i class="bi bi-chat-square-text-fill"></i></span>
                    <select id="tipoentidade_id" name="tipoentidade_id" class="form-control">
                        <option value="">Tipo</option>
                        @foreach($ResultTipoEntidades as $result)
                        <option value="{{ $result->id }}"                            
                            @if($ResultEntidades[0]['tipoentidade_id'] == $result->id) selected="selected" @endif>{{ $result->name }}</option>
                        @endforeach
                    </select>
                    </div>
                 </td>
              </tr>
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Nome" value="{{ $ResultEntidades[0]['name'] }}">
                    </div>
                 </td>
              </tr>
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input id="fone" name="fone" type="text" class="form-control" placeholder="Telefone" value="{{ $ResultEntidades[0]['fone'] }}">
                    </div>
                </td>
              </tr>
              <tr>
                <td align="left"><a href="{{ url('/Entidades') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a></td>
                <td align="right"><button type="submit" class="btn btn-success"> <i class="bi bi-file-plus-fill"></i> Salvar</button></td>
            </tr>            
            <tbody>

                  </tr>

                </tbody>
            </table>
        </form>

    </div>

  </div>
</div>
@endsection
