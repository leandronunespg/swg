<!DOCTYPE html>
<html>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

<head>
    <title>Orçamento {{ $ResultOrcamento->id }}</title>
</head>
<body>
        
<table class="table table-bordered" style="border:solid 1px; width:100%">
            <tr>
                <td colspan="4" class="text-center">
                    <h2 class="text-decoration-underline">{{ $ResultEmpresa->name }}</h2>
                    {{ $ResultEmpresa->razao_social }}<br>
                    <span class="fw-bold" style="font-size: 16px">Fone: {{ $ResultEmpresa->tel }}<br>
                    Rua: {{ $ResultEmpresa->address.", ".$ResultEmpresa->number_address." - ".$ResultEmpresa->district }} <br>
                    Cep: {{ $ResultEmpresa->cep_emitente." - ".$ResultEmpresa->city." - ".$ResultEmpresa->state }} </span>

                </td>
            </tr>            
            <tr>
                <td colspan="4"><hr></td>                
            </tr>
            <tr>
                <td colspan="4"><h3>Orçamento - {{ str_pad($ResultOrcamento->id , 5 , '0' , STR_PAD_LEFT); }}</h3></td>
            </tr>            
            <tr>
                <td colspan="4"><h3>Dados do Cliente</h3></td>
            </tr>                       
            <tr>
                <td style="width: 10%"><strong>Cliente: </strong></td>
                <td colspan="3">{{ @$ResultOrcamento->Entidades() }}</td>
            </tr>
            <tr>
                <td style="width: 10%"><strong>Telefone: </strong></td>
                <td colspan="3">{{ @$ResultOrcamento->delivery_fone }} / {{ @$ResultOrcamento->delivery_fone2 }}</td>
            </tr>
            <tr>
                <td><strong>Endereço:</strong></td>
                <td colspan="3">{{ @$ResultOrcamento->delivery_address }}, {{ @$ResultOrcamento->delivery_number}}</td>
                </tr>
            <tr>
                <td><h4>Cep:</h4></td>
                <td style="width: 20%">{{ @$ResultOrcamento->delivery_zip_code}}</td>
                <td style="width: 10%"><h4>Bairro:</h4></td>
                <td>{{ @$ResultOrcamento->delivery_district}}</td>
            </tr>
            <tr>
                <td><strong>Cidade: </strong></td>
                <td colspan="3">{{ @$ResultOrcamento->delivery_city }} / {{ @$ResultOrcamento->delivery_state }}</td>
            </tr>
            <tr>
                <td colspan="4"><hr></td>                
            </tr>
            <tr>
                <td colspan="4"><h4>Dados da Entrega</h4></td>                
            </tr>
            <tr>
                <td><strong>Data da Entrega: </strong></td>
                <td colspan="3">{{ substr($ResultOrcamento->date,8,2)."/".substr($ResultOrcamento->date,5,2)."/".substr($ResultOrcamento->date,0,4) }}</td>
            </tr>
            <tr>
                <td><strong>Observação: </strong></td>
                <td colspan="3">{{ @$ResultOrcamento->note }}</td>
            </tr>
            <tr>
                <td colspan="4"><hr></td>                
            </tr>
            <tr>
                <td colspan="4"><h4>Dados do Orcamento</h4></td>                
            </tr>
            <tr>
                <td style="width: 20%"><strong>Data: </strong></td>
                <td colspan="3">{{ substr($ResultOrcamento->date,8,2)."/".substr($ResultOrcamento->date,5,2)."/".substr($ResultOrcamento->date,0,4) }}   
               </td>
            </tr>
            <tr>
                <td><strong>Valor Orçamento: </strong></td>
                <td colspan="3">{{ number_format(@$ResultOrcamento->total,2,'.','') }}</td>
            </tr>
            <tr>
                <td><strong>Valor do Frete: </strong></td>
                <td colspan="3">{{ number_format(@$ResultOrcamento->valor_frete,2,'.','') }}</td>
            </tr>
            <tr>
                <td><strong>Valor Total: </strong></td>
                <td colspan="3">{{ number_format(@$ResultOrcamento->grand_total,2,'.','') }}</td>
            </tr>
            
        </table>


        <table id='tableItens' class="table table-bordered" style="border:solid 1px; width:100%; font-size:12px">
            <thead>
                <tr style="border-bottom:solid 1px">
                    <th style="width: 20%">Produto</th>
                    <th style="width: 10%" class="text-center">Valor</th>
                    <th style="width: 10%" class="text-center">Qtde</th>
                    <th style="width: 10%" class="text-center">Total</th>
                    <th style="width: 10%" class="text-center">Largura</th>
                    <th style="width: 10%" class="text-center">Espessura</th>
                    <th style="width: 10%" class="text-center">Comprimento</th>
                    <th style="width: 10%" class="text-center">Qtd M²</th>
                    <th style="width: 10%" class="text-center">Total M²</th>
                </tr>
                <tbody id="divItens">
                    @if($ResultOrcamento == true)
                    @foreach($ResultItensOrcamento as $result)
                    <tr style="border-bottom:solid 1px">
                        <td style="width: 20%">{{ $result->Product() }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->unit_price }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->quantity }}</td>
                        <td style="width: 10%" class="text-center vlr">{{ $result->subtotal }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->largura }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->espessura }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->comprimento }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->qtde_quadrado }}</td>
                        <td style="width: 10%" class="text-center">{{ $result->total_quadrado }}</td>                        
                    </tr>
                    @endforeach   
                    @endif
                </tbody>
            </thead>                              
        </table>
        
        <table id='tableItens' class="table table-bordered" style="border:solid 1px; width:100%; font-size:12px">
            <thead>
                <tr>
                    <td colspan="4" class="text-center"><h4>{{ $ResultEmpresa->footer }}</h4></td>
                </tr>
                
            </thead>
        </table>

       
     

</body>
</html>