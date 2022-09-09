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

$(document).ready(function() {
    $('#BtRelacao').click(function() {
        
        $.ajax({
            url: "/EntradaProduto", //consultando na minha rota
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") //token obrigatório
            },
            data: {
               
            },
            success: function(resposta) {    //retorno da resposta da minha rota                    
               
                var RelacaoEntradas = [];
                    $.each(resposta, function(k, v) {//loop para criar os registros
                        // RelacaoEntradas += "<option value='"+ v["id"] +"'>"+ v["name"] +"</option>";//tabela com o resultado da consulta
                        RelacaoEntradas += "<table class='display table table-striped w-100' id='datatable-buttons'>";
                        RelacaoEntradas += "<tbody>";
                        RelacaoEntradas += "<tr>";
                        RelacaoEntradas += "<td style='width: 20%' align='left'>"+v['entidade_id']+"</td>";
                        RelacaoEntradas += "<td style='width: 10%' align='left'>"+v['centrocusto_id']+"</td>";
                        RelacaoEntradas += "<td style='width: 10%' align='left'>"+v['historico_id']+"</td>";
                        RelacaoEntradas += "<td style='width: 10%' align='left'>"+v['user_id']+"</td>";
                        RelacaoEntradas += "<td style='width: 10%' align='right'>"+v['total']+"</td>";
                        RelacaoEntradas += "<td style='width: 10%' align='center'>"+v['date']+"</td>";
                        RelacaoEntradas += "<td style='width: 10%' align='center'>";
                        RelacaoEntradas += "<a href='/Lancamentos/Editar/'><i class='bi bi-pencil-square'></i></a>";
                        RelacaoEntradas += "<a href='javascript:del({{ $resultado->id }})'><i class='bi bi-trash' style='color:red;'></i></a>";
                        RelacaoEntradas += "</td>";
                        RelacaoEntradas += "</tr>";
                        RelacaoEntradas += "</tbody>";
                        RelacaoEntradas += "</table>";
                    });

                    $("#RelacaoDiv").html(RelacaoEntradas);//div onde adicionará o resultado dos dados
            },
                error: function(resposta) {
                console.log("Deu errado!");
                Vazio = "<option value=''>Histórico</option>";//ao clicar no label histórico
                $("#historico_id").html(Vazio);//compo box onde adicionará o resultado dos dados
            },
        });


    });
});