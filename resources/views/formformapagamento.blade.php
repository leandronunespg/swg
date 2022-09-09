@extends('layout.app')

@section('content')


<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Forma de Pagamento</h4>      
      <form method="POST" action="{{ route('formapagamento.salvar') }}">
        @csrf
        <table class="table">                            
              <tr>
                <td colspan="2"> 
                    <div class="input-group">
                    <span class="input-group-addon input-group-text"><i class="bi bi-currency-exchange"></i></span>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Nome" required>
                    </div>
                 </td>
              </tr>
             
              <tr>
                <td class="text-start"><a href="{{ url('/FormaPagamento') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a></td>
                <td class="text-end"><button type="submit" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Salvar</button></td>
            </tr>            
            <tbody>


            </table>
        </form>
  </div>
  </div>
</div>
@endsection
