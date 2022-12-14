<!DOCTYPE html>
<html>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
</script>

<head>
    <title>Pedido {{ str_pad($ResultPedido->id, 5, '0', STR_PAD_LEFT) }}</title>
</head>

<body>
    

    <table class="table table-bordered text-star fw-normal" style="border:solid 1px; width:100%">
        <tr>
            <td colspan="2" class="text-start">
               <img src="../public/img/logoempresa.png" style="width:200px;">
            </td>
            <td colspan="2" class="text-end">             
                <span class="fw-bold" style="font-size:16px">
                    Fone: {{ $ResultEmpresa->tel }}
                </span><br>
                <span class="fw-bold" style="font-size:13px">
                Rua:
                    {{ $ResultEmpresa->address . ', ' . $ResultEmpresa->number_address . ' - ' . $ResultEmpresa->district }}
                    <br>
                    Cep: {{ $ResultEmpresa->cep_emitente . ' - ' . $ResultEmpresa->city . ' - ' . $ResultEmpresa->state }}
                </span>

            </td>
        </tr>
        <tr>
            <td colspan="4">
            
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border:solid 1px"><strong class='fs-6'>Pedido -
                    {{ str_pad($ResultPedido->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
        </tr>
        
        <tr>
            <td style="width: 10%" style="border:solid 1px">
                <strong class="fw-bold">Cliente: </strong>
            </td>
            <td colspan="3" style="border:solid 1px"> {{ @$ResultPedido->Entidades() }}</td>
        </tr>
        <tr>
            <td style="width: 10%; border:solid 1px"><strong>Telefone: </strong></td>
            <td colspan="3" style="width: 10%; border:solid 1px">{{ @$ResultPedido->delivery_fone }} / {{ @$ResultPedido->delivery_fone2 }}</td>
        </tr>
        <tr>
            <td style="border:solid 1px">
                <strong class="fw-bold">Endere??o: </strong>
            </td>
            <td colspan="3" style="border:solid 1px"> {{ @$ResultPedido->delivery_address }}, {{ @$ResultPedido->delivery_number }}</td>
        </tr>
        <tr>
            <td style="border:solid 1px"><strong class="fw-bold">Cep:</strong></td>
            <td style="width: 20%; border:solid 1px">{{ @$ResultPedido->delivery_zip_code }}</td>
            <td style="width: 10%; border:solid 1px"><strong class="fs-6">Bairro:</strong></td>
            <td style="border:solid 1px">{{ @$ResultPedido->delivery_district }}</td>
        </tr>
        <tr>
            <td style="border:solid 1px"><strong>Cidade: </strong></td>
            <td colspan="3" style="border:solid 1px">{{ @$ResultPedido->delivery_city }} / {{ @$ResultPedido->delivery_state }}</td>
        </tr>
        <tr>
            <td style="border:solid 1px"><strong>Data da Entrega: </strong></td>
            <td colspan="3" style="border:solid 1px">
                {{ substr($ResultPedido->date, 8, 2) . '/' . substr($ResultPedido->date, 5, 2) . '/' . substr($ResultPedido->date, 0, 4) }}
            </td>
        </tr>
        <tr>
            <td style="border:solid 1px"><strong>Observa????o: </strong></td>
            <td colspan="3" style="border:solid 1px"></td>
        </tr>
        
        <tr>
            <td style="width: 20%; border:solid 1px"><strong>Data: </strong></td>
            <td colspan="3" style="border:solid 1px">
                {{ substr($ResultPedido->date, 8, 2) . '/' . substr($ResultPedido->date, 5, 2) . '/' . substr($ResultPedido->date, 0, 4) }}
            </td>
        </tr>
        <tr>
            <td style="border:solid 1px"><strong>Total dos Itens: </strong></td>
            <td colspan="3" style="border:solid 1px"> R$ {{ number_format(@$ResultPedido->total, 2, '.', '') }}</td>
        </tr>
        <tr>
            <td style="border:solid 1px"><strong>Total do Frete: </strong></td>
            <td colspan="3" style="border:solid 1px"> R$ {{ number_format(@$ResultPedido->valor_frete, 2, '.', '') }}</td>
        </tr>
        <tr>
            <td style="border:solid 1px"><strong>Total Final: </strong></td>
            <td colspan="3" style="border:solid 1px"> R$ {{ number_format(@$ResultPedido->grand_total, 2, '.', '') }}</td>
        </tr>

    </table>
    <strong class="fs-6 text">Observa????o</strong>
    <table id='tableItens' class="table table-bordered" style="border:solid 1px; width:100%; font-size:12px">
        <thead>
                  <tr>
                <td colspan="2" class="text-start">
                    {{ @$ResultPedido->note }}
                </td>
            </tr>

        </thead>
    </table>

    <strong class="fs-6 text">Itens do Pedido</strong>
    <table id='tableItens' class="table table-bordered" style="border:solid 1px; width:100%; font-size:12px">
        <thead>
            <tr style="border-bottom:solid 1px">
                <th>#</th>
                <th style="width: 20%">Produto</th>
                <th style="width: 10%" class="text-start">Valor</th>
                <th style="width: 10%" class="text-center">Qtde</th>
                <th style="width: 10%" class="text-center">Total</th>
                <th style="width: 10%" class="text-center">Qtd M??</th>
                <th style="width: 10%" class="text-center">Total M??</th>
            </tr>
        <tbody id="divItens">
            @if ($ResultPedido == true)
                @foreach ($ResultItemsPedido as $key => $result)
                    <tr style="border-bottom:solid 1px">
                        <td style="width: 2%">{{ $key + 1 }}</td>
                        <td style="width: 20%">{{ $result->Product() }}</td>
                        <td style="width: 10%" class="text-start">{{ $result->unit_price }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->quantity }}</td>
                        <td style="width: 10%" class="text-center vlr">{{ $result->subtotal }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->qtde_quadrado }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->total_quadrado }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        </thead>
    </table>


    <strong class="fs-6 text">Movimento Financeiro</strong>
    <table id='tableItens' class="table table-striped w-100 Pedido" style="border:solid 1px; font-size:12px;">
        <thead>
            <tr style="border-bottom:solid 1px;font-size:12px">
                <th>#</th>
                <th class="text-start">Forma de Pagamento</th>
                <th class="text-end">Valor</th>
                <th class="text-end">Data ?? pagar</th>
                <th class="text-center">Situa????o</th>
                <th class="text-center">Data pagamento</th>
            </tr>
        <tbody id="divItens">
            @if ($ResultPedido == true)
                @foreach ($ResultLancamento as $key => $result)
                    <tr style="border-bottom:solid 1px;font-size:12px">
                        <td style="width: 2%">{{ $key + 1 }}</td>
                        <td style="" class="text-start">{{ $result->FormaPagamento() }}</td>                       
                        <td style="width: 10%" class="text-end">{{ number_format($result->price, 2, '.', '') }}</td>
                        <td style="width: 15%" class="text-center">{{ $result->FormatData() }}</td>
                        <td style="width: 15%" class="text-center">
                            @if ($result->payday == true)
                                Recebido
                            @else
                                Em aberto
                            @endif
                        </td>
                        <td style="width: 15%" class="text-center">{{ $result->payday }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        </thead>
    </table>

    <strong class="fs-6 text">Aten????o</strong>
    <table id='' class="table table-bordered" style="border:solid 1px; width:100%; font-size:12px">
        <thead>
            <tr>
                <td colspan="4" class="text-star fw-normal">
                    1-Fixamos o prazo de 7 dias corridos a partir da data da entrega da mercadoria para troca.<br>
                    2-S?? ser?? aceita a troca dos produtos.<br>
                    2.1-Sem ind??cios de uso (os produtos dever??o ser devolvidos em suas condi????es originais).<br>
                    2.2-Com vicio ou defeito comprovado.<br>
                    2.3-N??o ser?? aceita a troca ou devolu????o mercadorias com respingos de reboco, pintura Perfura????es e
                    marcas/furos de pregos e/ou parafusos.<br>
                    3-H?? que se respeitar as caracter??sticas naturais da madeira, as mesmas podem conter n??s e varia????es
                    de cor por ser de origem natural (pode apresentar rachaduras, fissuras, curvas ou entortamento)
                    essas caracter??sticas n??o podem ser consideradas como defeitos ou v??cios.<br>
                    4-Produtos comprados com valores promocionais devido a pequenas avarias que justificam a redu????o do
                    pre??o, n??o possibilitar?? troca ou reclama????o sobre o estado da mercadoria, declarando desde j?? o
                    CLIENTE o conhecimento das condi????es do produto.<br>
                    5-Produtos que n??o apresentem v??cios ou defeitos, n??o ?? de obrigatoriedade da loja realizar a troca
                    ou cancelamento.<br>
                    6-Madeiras aplainadas devido ao beneficiamento perdem medidas.<br>
                    7-Caso a entrega n??o seja efetivada, por aus??ncia de um respons??vel para o recebimento dos produtos,
                    os mesmos voltar??o para loja ????, ficando o cliente respons??vel por pagar frete e entrega.<br>
                    <p></p>
                    <span class="fs-6">TERMO DE ENTREGA DE MERCADORIA </span><br>
                    Eu <strong>{{ $ResultPedido->Entidades() }}</strong>, declaro que recebi da
                    <strong>{{ $ResultEmpresa->name }}</strong>, inscrita no CNPJ Sob n??
                    <strong>{{ $ResultEmpresa->FormatCnpj() }}</strong> nesta data, as mercadorias em perfeito
                    estado.<br>
                    -As mercadorias ser??o descarregadas onde o ve??culo conseguir estacionar.<br>
                    -No caso de condom??nio, autorizo a entrada para realizarem a entrega da mercadoria.<br>
                    Sendo eu (o cliente) respons??vel por eventuais danos que o mesmo possa causar na pavimenta????o ou
                    cal??adas. ________/________/_________.
                    <p></p>

                </td>
            </tr>

        </thead>
    </table>
<br>
    <table id='tableItens' class="table table-bordered" style="border:solid 1px; width:100%; font-size:12px">
        <thead>
            <tr>
                <td colspan="4" class="text-center align-self-center">
                    <h4>{{ $ResultEmpresa->footer }}</h4>
                </td>
            </tr>

        </thead>
    </table>


</body>

</html>
