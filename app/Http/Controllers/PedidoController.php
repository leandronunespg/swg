<?php

namespace App\Http\Controllers;

use App\Models\lancamento;
use App\Models\centrocusto;
use App\Models\historico;
use App\Models\entidades;
use App\Models\formapagamento;
use App\Models\produtos;
use App\Models\entradaproduto;
use App\Models\User;
use App\DataTables\LancamentoDataTable;
use App\Models\pedido;
use App\Models\pedidoitems;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Carbon;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

 
    public function index(Request $request){
           
        $ResultPedido  = pedido::all();

        return view('pedido',compact('ResultPedido')); 
                
    
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
       
      
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){               

        $entrada_id = entradaproduto::select('id')->latest('id')->first();

        if($entrada_id == null){
            $entrada_id = 1;
        }else{
            $entrada_id = $entrada_id->id+1;
        }

        
       //trás o cabeçalho da entrada de produtos       
       $cabecalho = array(
             'entidade_id'       => $request->entidade_id,            
             'centrocusto_id'    => $request->centrocusto_id,
             'historico_id'      => $request->historico_id,
             'note'              => $request->note,
             'user_id'           => 1,//$request->user_id,
             'note_number'       => $request->note_number,
             'total'             => $request->totalnota,
             'date'              => $request->date          
            );
             //insere o cabecalho dos dados da entrada
            //   dd($cabecalho);    
             entradaproduto::create($cabecalho);

        //trás as parcelas da entrada de nota
        $dadosFinanceiro = [];    
        foreach($request->parcela_id as $key => $result ){

            if($request->parcela_date[$key] == date("Y-m-d")){
                $parcela_status = "P";
            }else{
                $parcela_status = "A";
            }

            $dadosFinanceiro = array(

            'centrocusto_id'      => $request->centrocusto_id,
            'historico_id'        => $request->historico_id,
            'entradaproduto_id'   => $entrada_id,
            'entidade_id'         => $request->entidade_id,
            'user_id'             => 1,//$request->user_id,
            'price'               => $request->parcela_price[$key],
            'formapagamento_id'   => $request->formapagamento_id[$key],
            'date'                => $request->parcela_date[$key],
            'status'              => $parcela_status,
            );
            
            //insere as parcelas da entrada de nota
            lancamento::create($dadosFinanceiro);
            //echo "<pre>".print_r($dadosFinanceiro)."</pre>";
        }
        //die();

        //trás os itens da entrada de nota
        $data = []; 
        foreach($request->product_id as $key => $result ){  
 
            $explode1 = explode('[', $request->product_id[$key]);
            $explode2 = explode(']',$explode1[1]);
            $codproduto = trim($explode2[0]);                 
          
	    $data = array(
            'entrada_id'    => $entrada_id,
            'product_id'    => $codproduto,
            'quantity'      => $request->quantity[$key],
            'price'         => $request->price[$key],
            'total'         => $request->total[$key],
            'largura'       => $request->largura[$key],
            'espessura'     => $request->espessura[$key],
            'comprimento'   => $request->comprimento[$key],
            'qtde_quadrado' => $request->qtde_quadrado[$key],
            'total_quadrado'=> $request->total_quadrado[$key],                       
        ); 
        //insere os produtos da entrada de produtos
        entradaitens::create($data);     
     }    
        return redirect("/EntradaProduto/Adicionar")->with('success_message','Post was created!');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function show(lancamento $lancamento){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function edit($id){        
      
        $ResultEntidade          = entidades::all();
        $ResultUser              = User::all();
        $ResultPedido            = pedido::where('id',$id)->first();
        $ResultItemsPedido       = pedidoitems::where('pedido_id',$id)->get();
        $ResultCentroCusto       = centrocusto::orwhere('name','like','vendas')->get();
        $ResultHistorico         = historico::all();
        $ResultFormaPagamento    = formapagamento::all();
        $ResultLancamento        = lancamento::where('pedido_id',$id)->get();

       // dd($ResultLancamento);
        
        return view('formpedido', compact('ResultPedido','ResultLancamento','ResultFormaPagamento','ResultHistorico','ResultCentroCusto','ResultItemsPedido','ResultUser','ResultEntidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        
        $dadosFinanceiro = [];    
        foreach($request->parcela_id as $key => $result ){

            if($request->parcela_date[$key] == date("Y-m-d")){
                $parcela_status = "P";
            }else{
                $parcela_status = "A";
            }

            $dadosFinanceiro = array(

            'centrocusto_id'      => $request->centrocusto_id,
            'historico_id'        => $request->historico_id,
            'pedido_id'           => $id,           
            'user_id'             => 1,//$request->user_id,
            'price'               => $request->parcela_price[$key],
            'formapagamento_id'   => $request->formapagamento_id[$key],
            'date'                => $request->parcela_date[$key],
            'type'                => 'C',
            'date_aprovacao'      => date("Y-m-d"),
            'status'              => $parcela_status,
            );
            
            //insere as parcelas da entrada de nota
            lancamento::create($dadosFinanceiro);
            pedido::find($id)->update(['aprovado' => 'S']);
            //echo "<pre>".print_r($dadosFinanceiro)."</pre>";
        }
        return redirect("/Pedido/Editar/$id")->with('pedido_gerado_message','Post was update!');      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultLancamento = lancamento::where('id',$id)->delete();        
        return redirect("/Lancamentos/A/")->with('deleted_message','Post was deleted!');  
    }
}
