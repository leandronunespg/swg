@extends('layout.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Tipo de Entidades</h4>
      
      <form method="POST" action="{{ route('tipoentidade.atualizar',$ResultTipoEntidade[0]['id']) }}">
        @csrf
        <table class="table">              
                 
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                      <span class="input-group-addon input-group-text "><i class="bi bi-people-fill"></i></span>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Nome" value="{{ $ResultTipoEntidade[0]['name'] }}">
                    </div>
                 </td>
              </tr>             
              <tr>
                <td align="left"><a href="{{ url('/TipoEntidade') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a></td>
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

