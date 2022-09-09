@extends('layout.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Centro de Custo</h4>
      
      <form method="POST" action="{{ route('centrocusto.atualizar',$ResultCentroCusto[0]['id']) }}">
        @csrf
        <table class="table">              
                     
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text"><i class="bi bi-chat-square-text-fill"></i></span>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Nome" value="{{ $ResultCentroCusto[0]['name'] }}">
                    </div>
                 </td>
              </tr>             
              <tr>
                <td align="left"><a href="{{ url('/CentroCusto') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a></td>
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
