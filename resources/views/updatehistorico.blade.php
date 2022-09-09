@extends('layout.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Históricos</h4>
      
      <form method="POST" action="{{ route('historico.atualizar',$ResultHistorico[0]['id']) }}">
        @csrf
        <table class="table">              
             
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                      <span class="input-group-addon input-group-text"><i class="bi bi-chat-square-text-fill"></i></span>
                    <select id="tipoentidade_id" name="tipoentidade_id" class="form-control">
                        <option value="">Centro de Custo</option>
                        @foreach($ResultCentroCusto as $result)
                        <option value="{{ $result->id }}"                            
                            @if($ResultHistorico[0]['centrocusto_id'] == $result->id) selected="selected" @endif>{{ $result->name }}</option>
                        @endforeach
                    </select>
                    </div>
                 </td>
              </tr>
              
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Nome" value="{{ $ResultHistorico[0]['name'] }}">
                    </div>
                 </td>
              </tr>              
              <tr>
                <td align="left"><a href="{{ url('/Historico') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a></td>
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