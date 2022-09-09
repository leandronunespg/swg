@extends('layout.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Parceiro de Negócio</h4>      
      <form method="POST" action="@if(!@$ResultEntidades){{ route('entidades.salvar') }}@else {{ route('entidades.atualizar',$ResultEntidades->id) }} @endif">
        @csrf

        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#DadosGerais">Dados Gerais</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#DadosExtras">Dados Extra</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#DemaisDados">Demais Dados</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#HistoricoVendas">Hitórico de Vendas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#HistoricoCompras">Hitórico de Compras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#HistoricoFinanceiro">Hitórico Financeiro</a>
          </li>
        </ul>
      
        <!-- Tab panes -->
        <div class="tab-content">
          <div id="DadosGerais" class="container tab-pane active"><br>
            <div class="row">
              <div class="col-sm-12 p-1">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">                 
                  <label class="btn btn-secondary active">
                    <input type="radio" name="type" id="type" value="F" autocomplete="off" @if(@$ResultEntidades->type == "F") checked="true" @endif> Física 
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="type" id="type" value="J" autocomplete="off"  @if(@$ResultEntidades->type == "J") checked="true" @endif> Jurídica
                  </label>
                 
                </div>
              </div>  
              <div class="col-sm-12 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-chat-square-text-fill"></i></span>
                  <select id="tipoentidade_id" name="tipoentidade_id" class="form-control" required>
                      <option value="">Tipo Parceiro</option>
                      @foreach($ResultTipoEntidades as $result)
                      <option value="{{ $result->id }}" @if(@$ResultEntidades->tipoentidade_id == $result->id) selected @endif>{{ $result->name }}</option>
                      @endforeach
                  </select>
                  </div>              
              </div> 

              <div class="col-sm-6 p-1">
                    <div class="input-group">
                      <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                      <input id="name" name="name" type="text" class="form-control" placeholder="Nome Fantasia" value="{{ @$ResultEntidades->name }}" required>
                    </div>
              </div>
              <div class="col-sm-6 p-1">
                  <div class="input-group">
                      <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                      <input id="razao" name="razao" type="text" class="form-control" placeholder="Razão Social" value="{{ @$ResultEntidades->razao }}" required>
                  </div>
              </div>
              <div class="col-sm-3 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="zip_code" name="zip_code" type="text" class="form-control" placeholder="Cep" value="{{ @$ResultEntidades->zip_code }}">
                  </div>
              </div>
             
              <div class="col-sm-3 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="district" name="district" type="text" class="form-control" placeholder="Bairro" value="{{ @$ResultEntidades->district }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="address" name="address" type="text" class="form-control" placeholder="Endereço" value="{{ @$ResultEntidades->address }}">
                </div>
              </div>
              <div class="col-sm-2 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="number" name="number" type="text" class="form-control" placeholder="Número" value="{{ @$ResultEntidades->number }}">
                  </div>
              </div>
              
              <div class="col-sm-8 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="city" name="city" type="text" class="form-control" placeholder="Cidade" value="{{ @$ResultEntidades->city }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="state" name="state" type="text" class="form-control" placeholder="Estado" value="{{ @$ResultEntidades->state }}">
                  </div>
              </div>
             
              <div class="col-sm-4 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="fone" name="fone" type="text" class="form-control" placeholder="(00) 0000-0000" value="{{ @$ResultEntidades->fone }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="fone2" name="fone2" type="text" class="form-control" placeholder="(00) 0000-0000" value="{{ @$ResultEntidades->fone2 }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1 ">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="email" name="email" type="text" class="form-control" placeholder="E-mail" value="{{ @$ResultEntidades->email }}">
                  </div>
              </div>



            </div>               
          </div>



          <div id="DadosExtras" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="branch_activity" name="branch_activity" type="text" class="form-control" placeholder="Ramo de Atividade" value="{{ @$ResultEntidades->branch_activity }}">
                </div>
              </div>  
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="area_activity" name="area_activity" type="text" class="form-control" placeholder="Área de Atuação" value="{{ @$ResultEntidades->area_activity }}">
                  </div>
              </div>  
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="profession" name="profession" type="text" class="form-control" placeholder="Profissão" value="{{ @$ResultEntidades->profession }}">
                  </div>
              </div>  
              
              <div class="col-sm-3 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="cnpj" name="cnpj" type="text" class="form-control" placeholder="CNPJ" value="{{ @$ResultEntidades->cnpj }}">
                  </div>
              </div>  
              <div class="col-sm-3 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="cpf" name="cpf" type="text" class="form-control" placeholder="CPF" value="{{ @$ResultEntidades->cpf }}">
                  </div>
              </div>  
              <div class="col-sm-3 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="rg" name="rg" type="text" class="form-control" placeholder="RG" value="{{ @$ResultEntidades->rg }}">
                  </div>
              </div>  
              <div class="col-sm-3 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="ie" name="ie" type="text" class="form-control" placeholder="Inscrição Estadual" value="{{ @$ResultEntidades->ie }}">
                  </div>
              </div>  
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="pis" name="pis" type="text" class="form-control" placeholder="pis" value="{{ @$ResultEntidades->pis }}">
                  </div>
              </div>  
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="cad_pro" name="cad_pro" type="text" class="form-control" placeholder="Cad Pró (produtor rural)" value="{{ @$ResultEntidades->cad_pro }}">
                  </div>
              </div>  
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="nationality" name="nationality" type="text" class="form-control" placeholder="Nacionalidade" value="{{ @$ResultEntidades->nationality }}">
                  </div>
              </div>  

            </div>
          </div>


          <div id="DemaisDados" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-12 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="mother" name="mother" type="text" class="form-control" placeholder="Nome da Mãe" value="{{ @$ResultEntidades->mother }}">
                  </div>
              </div>
              <div class="col-sm-12 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-people-fill"></i></span>
                  <input id="dad" name="dad" type="text" class="form-control" placeholder="Pai" value="{{ @$ResultEntidades->dad }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-telephone-fill"></i></span>
                  <input id="dependent1" name="dependent1" type="text" class="form-control" placeholder="Dependente" value="{{ @$ResultEntidades->dependent1 }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-telephone-fill"></i></span>
                  <input id="dependent2" name="dependent2" type="text" class="form-control" placeholder="Dependente" value="{{ @$ResultEntidades->dependent2 }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-telephone-fill"></i></span>
                  <input id="dependent3" name="dependent3" type="text" class="form-control" placeholder="Dependente" value="{{ @$ResultEntidades->dependent3 }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-telephone-fill"></i></span>
                  <input id="dependent4" name="dependent4" type="text" class="form-control" placeholder="Dependente" value="{{ @$ResultEntidades->dependent4 }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-telephone-fill"></i></span>
                  <input id="dependent5" name="dependent5" type="text" class="form-control" placeholder="Dependente" value="{{ @$ResultEntidades->dependent5 }}">
                  </div>
              </div>
              <div class="col-sm-4 p-1">
                <div class="input-group">
                  <span class="input-group-addon input-group-text"><i class="bi bi-telephone-fill"></i></span>
                  <input id="dependent6" name="dependent6" type="text" class="form-control" placeholder="Dependente" value="{{ @$ResultEntidades->dependent6 }}">
                  </div>
              </div>


            </div>
          </div>

          <div id="HistoricoVendas" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-12 p-1 card">
                <table class="table table-striped table-border table-hover">
                  <thead>
                  <tr>
                    <td>Data</td>
                    <td>Frete</td>
                    <td>Total</td>
                  </tr>
                  </thead>
                  @foreach($ResultPedidos as $result)
                  <tr>
                    <td>{{ $result->FormatData() }}</td>
                    <td>{{ $result->valor_frete }}</td>
                    <td>{{ number_format($result->grand_total,2,',','.') }}</td>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
          
          <div id="HistoricoCompras" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-12 p-1 card">
                <table class="table table-striped table-border table-hover">
                  <thead>
                    <tr>
                    <td>Data</td>
                    <td>Nº Nota</td>
                    <td>Total</td>
                  </tr>
                  </thead>
                  @foreach($ResultCompras as $result)
                  <tr>
                    <td>{{ $result->FormatData() }}</td>
                    <td>{{ $result->note_number }}</td>
                    <td>{{ number_format($result->total,2,',','.') }}</td>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
         
          <div id="HistoricoFinanceiro" class="container tab-pane fade"><br>
            <div class="row">
                <div class="col-sm-12 p-1 card">
                  <table class="table table-striped table-border table-hover">
                    <thead>
                    <tr>
                      <td>Data</td>
                      <td>Nº Pedido</td>
                      <td>Total</td>
                      <td>Situação</td>
                    </tr>
                    </thead>
                    @foreach($ResultFinanceiro as $result)
                    <tr>
                      <td>{{ $result->FormatData() }}</td>
                      <td>{{ $result->pedido_id }}</td>
                      <td>{{ number_format($result->price,2,',','.') }}</td>
                      <td>@if($result->status == "A") Em Aberto @else Pago @endif</td>
                    </tr>
                    @endforeach
                  </table>
                </div>
              </div>
          </div>

        </div>
       
        <div class="row p-1">
          <div class="col-sm-12" align="right">
            <a href="{{ url('/Entidades') }}"><button type="button" class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a>
            <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Salvar</button>
          </div>
        </div>
        
        </form>
  </div>
  </div>
</div>
@endsection

