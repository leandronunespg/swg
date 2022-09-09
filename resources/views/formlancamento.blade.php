@extends('layout.app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>Lançamentos Financeiros</h4>
                <form method="POST" action="{{ route('lancamentos.salvar') }}">
                    @csrf
                    <table class="table" style="">
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-text"><i class="bi bi-arrow-90deg-down"></i></span>
                                    <select id="centrocusto_id" name="centrocusto_id" class="form-control" required>
                                        <option value="">Centro de Custo</option>
                                        @foreach ($ResultCentroCusto as $result)
                                            <option value="{{ $result->id }}">{{ $result->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-text"><i class="bi bi-arrow-90deg-right"></i></span>                                  
                                    <select id="historico_id" name="historico_id" class="form-control" required>
                                        <option value="">Histórico</option>
                                        
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <select id="entidade_id" name="entidade_id" class="form-control" required>
                                        <option value="">Entidade</option>
                                        @foreach ($ResultEntidade as $result)
                                            <option value="{{ $result->id }}">{{ $result->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <select id="user_id" name="user_id" class="form-control" required>
                                        <option value="">Usuário</option>
                                        @foreach ($ResultUser as $result)
                                            <option value="{{ $result->id }}">{{ $result->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                    <input id="price" name="price" type="text" class="form-control" placeholder="Valor"
                                        required onKeyUp="mascaraMoeda(this, event)">
                                </div>
                            </td>
                        </tr>
                        <tr>
                          <td colspan="2"> 
                              <div class="input-group">
                              <span class="input-group-addon input-group-text"><i class="bi bi-currency-exchange"></i></span>
                              <select id="formapagamento_id" name="formapagamento_id" class="form-control" required>
                                  <option value="">Forma de Pagamento</option>
                                  @foreach($ResultFormaPagamento as $result)
                                  <option value="{{ $result->id }}"                            
                                      @if($ResultFormaPagamento[0]['formapagamento_id'] == $result->id) selected="selected" @endif>{{ $result->name }}</option>
                                  @endforeach
                              </select>
                              </div>
                           </td>
                        </tr>
                        <tr>
                            <td colspan="2"> 
                                <div class="input-group">
                                <span class="input-group-addon input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea id="note" name="note" class="form-control" placeholder="Observação">{{ $result->note }}</textarea>
                                </div>
                             </td>
                          </tr>
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-text"><i class="bi bi-calendar-date"></i></span>
                                    <input id="date" name="date" type="date" value="{{ date('Y-m-d')}}" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-text"><i class="bi bi-currency-exchange"></i></span>
                                        <select id="type" name="type" class="form-control" required>
                                            <option value="">Tipo</option>
                                            <option value="D">Débito</option>
                                            <option value="C">Crédito</option>                                           
                                        </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon input-group-text"><i class="bi bi-braces-asterisk" data-toggle="collapse" data-target="#replicar"></i></span>
                                    <div id="replicar" class="collapse">
                                    <input id="qtd" name="qtd" type="number" class="form-control" value="1">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-start"><a href="{{ url('/Lancamentos') }}"><button type="button"
                                        class="btn btn-info"><i class="bi bi-reply-all-fill"></i> Voltar</button></a></td>
                            <td class="text-end"><button type="submit" class="btn btn-success"><i
                                        class="bi bi-plus-circle-fill"></i> Salvar</button></td>
                        </tr>
                        <tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>

    $(document).ready(function() {
        $('#centrocusto_id').change(function() {
            let centrocusto_id = $('#centrocusto_id').val(); //Pegando o id do centro de custo
            $.ajax({
                url: "/ConsultaHistorico/" + centrocusto_id, //consultando na minha rota
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") //token obrigatório
                },
                data: {
                    centrocusto_id: centrocusto_id, //variável do campo centro de custo
                },
                success: function(resposta) {    //retorno da resposta da minha rota                    
                        var ItensOptions = [];
                        $.each(resposta, function(k, v) {//loop para criar os registros
                            ItensOptions += "<option value='"+ v["id"] +"'>"+ v["name"] +"</option>";//option com o resultado da consulta
                        });
                        $("#historico_id").html(ItensOptions);//combo box onde adicionará o resultado dos dados
                },
                error: function(resposta) {
                    console.log("Deu errado!");
                    Vazio = "<option value=''>Histórico</option>";//ao clicar no label histórico
                    $("#historico_id").html(Vazio);//compo box onde adicionará o resultado dos dados
                },
            });


        });
    });
</script>

@endpush
