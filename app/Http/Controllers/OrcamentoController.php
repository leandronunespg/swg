<?php

namespace App\Http\Controllers;

use App\Models\lancamento;
use App\Models\centrocusto;
use App\Models\historico;
use App\Models\entidades;
use App\Models\formapagamento;
use App\Models\produtos;
use App\Models\User;
use App\DataTables\LancamentoDataTable;
use App\Models\orcamento;
use App\Models\orcamentoitens;
use App\Models\tabelas;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Carbon;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

 
    public function index(Request $request){
           
        $ResultOrcamento  = orcamento::all();

        return view('orcamento',compact('ResultOrcamento')); 
                
    
    }

    public function ItemDestroy($id,$orcamento_id){
        $ResultItem = orcamentoitens::where('id',$id)->delete();        
        return redirect('Orcamento/Editar/'.$orcamento_id)->with('deleted_message','Deleted!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $ResultOrcamento          = ""; //precisa passar vazio porque utilizo o form para cadastrar/editar
        $ResultItensOrcamento    = ""; 
        $ResultUser              = User::all();                           
        $ResultCentroCusto      = centrocusto::all();
        $ResultHistorico        = historico::all();
        $ResultFormaPagamento   = formapagamento::all();
        $ResultEntidade         = entidades::select('entidades.name','entidades.id')
                                            ->where('tipoentidades.name','like','%cliente%')
                                         ->leftJoin('tipoentidades','tipoentidades.id','entidades.tipoentidade_id')
                                          ->orderBy('entidades.name','asc')
                                              ->get();  
                                              
                                        
                                                                                         
        
         return view('formorcamento',compact('ResultEntidade','ResultOrcamento','ResultItensOrcamento','ResultCentroCusto','ResultHistorico','ResultFormaPagamento')); 
    }
   
    public function calendariofinanceiro(){
        $ResultLancamento = lancamento::select("centrocustos.name as CentroCusto",
                                               "historicos.name as Historico",
                                               "entidades.name as Entidade",
                                               "users.name as Usuario",
                                               "formapagamentos.name as FormaPagamento",
                                               "lancamentos.price",
                                               "lancamentos.date",
                                               "lancamentos.payday",
                                               "lancamentos.status",
                                               "lancamentos.id")
                                     ->leftJoin("centrocustos","lancamentos.centrocusto_id","=","centrocustos.id")
                                     ->leftJoin("historicos","lancamentos.historico_id","=","historicos.id")
                                     ->leftJoin("entidades","lancamentos.entidade_id","=","entidades.id")
                                     ->leftJoin("users","lancamentos.user_id","=","users.id")
                                     ->leftJoin("formapagamentos","lancamentos.formapagamento_id","=","formapagamentos.id")
                                     ->whereNull("payday")
                                     
                                     ->get();

                                     
        
         $lancamentos = [];
        foreach($ResultLancamento as $key => $result){
            $lancamentos[] = array(
                                'id' => $result->id,                                               
                                'title' => "[".$result->price."]".$result->Entidade,                                               
                                'start' => $result->date,
                                'url' => "/Lancamentos/Editar/".$result->id,
                                );
        }
        
         return $lancamentos;
         
    }
    
    public function consultahistorico($id){
        $ConsultaHistorico  = historico::where('centrocusto_id',$id)->get();
        
        foreach ($ConsultaHistorico as $Rs => $Registros){
  
            $resposta[] = array(               
                'id'                 => $Registros->id,
                'name'               => $Registros->name,
            );
       
        }
       // dd($ConsultaHistorico);

        return $resposta;   
    }

    public function ConsultaEnderecoEntidade($entidade_id){             
        $resposta = [];
        $ResultEndereco = entidades::where('id',$entidade_id)->get();                   

        if (!empty($ResultEndereco)) {
              
            foreach ($ResultEndereco as $key => $registros){
                            
                $resposta = array(        
                    'address'             => $registros->address,                                                                                                                                                    
                    'number'              => $registros->number,                                                                                                                                                    
                    'fone'                => $registros->fone,                                                                                                                                                    
                    'fone2'               => $registros->fone2,                                                                                                                                                    
                    'district'            => $registros->district,                                                                                                                                                    
                    'city'                => $registros->city,                                                                                                                                                    
                    'state'               => $registros->state,                                                                                                                                                    
                    'zip_code'            => $registros->zip_code,                                                                                                                                                    
                );
            }
            // dd($resposta);
            return $resposta;
        }

    }

    public function ConsultaValorProduto(Request $request, $id){
        $identidade = $request->identidade;
       
        $resposta = [];
        $ResultItens = tabelas::select('tabela_precos.price')
                                ->leftJoin('tipoentidades','tipoentidades.id','=','tabela_precos.tipoentidade_id')
                                ->leftJoin('entidades','entidades.tipoentidade_id','=','tipoentidades.id')
                                ->where('product_id',$id)
                                ->where('entidades.id',$identidade)->get();                   

        if (!empty($ResultItens)) {
              
            foreach ($ResultItens as $key => $registros){
                            
                $resposta = array(        
                    'price'             => $registros->price,                                                                                                                                                    
                );
            }
            // dd($resposta);
            return $resposta;
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){   

        $orcamento_id = orcamento::select('id')->latest('id')->first();

        if($orcamento_id == null){
            $orcamento_id = 1;
        }else{
            $orcamento_id = $orcamento_id->id+1;
        }
        
       //trás o cabeçalho da entrada de produtos       
       $cabecalho = array(
             'entidade_id'       => $request->entidade_id,                        
             'user_id'           => 1,//$request->user_id,
             'note'              => $request->note,
             'note_number'       => $request->note_number,
             'valor_frete'       => $request->valor_frete,
             'total'             => $request->totalnota,
             'grand_total'       => $request->grand_total,
             'date'              => $request->date,          
             'delivery_address'  => $request->delivery_address,          
             'delivery_number'   => $request->delivery_number,          
             'delivery_zip_code' => $request->delivery_zip_code,          
             'delivery_district' => $request->delivery_district,          
             'delivery_city'     => $request->delivery_city,          
             'delivery_state'    => $request->delivery_state,          
             'delivery_fone'     => $request->delivery_fone,          
             'delivery_fone2'    => $request->delivery_fone2,          
            );
             //insere o cabecalho dos dados da entrada
            //  dd($cabecalho);    
            orcamento::create($cabecalho);
        

        //trás os itens do orçamento
        $data = []; 
        foreach($request->product_id as $key => $result ){  
 
            $explode1 = explode('[', $request->product_id[$key]);
            $explode2 = explode(']',$explode1[1]);
            $codproduto = trim($explode2[0]);                 
          
	    $data = array(
            'orcamento_id'    => $orcamento_id,
            'product_id'      => $codproduto,
            'quantity'        => $request->quantity[$key],
            'unit_price'      => $request->price[$key],            
            'subtotal'        => $request->total[$key],
            'largura'         => $request->largura[$key],
            'espessura'       => $request->espessura[$key],
            'comprimento'     => $request->comprimento[$key],
            'qtde_quadrado'   => $request->qtde_quadrado[$key],
            'total_quadrado'  => $request->total_quadrado[$key],                       
        ); 

        //insere os produtos da entrada de produtos
        orcamentoitens::create($data);     
     }    
        return redirect("/OrcamentoAdd/Adicionar")->with('success_message','Post was created!');  
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
        $ResultOrcamento         = orcamento::where('id',$id)->first();
        $ResultItensOrcamento    = orcamentoitens::where('orcamento_id',$id)->get();
        $ResultFormaPagamento    = formapagamento::all();
        
        
        return view('formorcamento', compact('ResultOrcamento','ResultItensOrcamento','ResultUser','ResultEntidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        
       //trás o cabeçalho da entrada de produtos       
       $cabecalho = array(
             'entidade_id'       => $request->entidade_id,                        
             'user_id'           => 1,//$request->user_id,
             'note'              => $request->note,
             'note_number'       => $request->note_number,
             'valor_frete'       => $request->valor_frete,
             'total'             => $request->totalnota,
             'grand_total'       => $request->grand_total,
             'date'              => $request->date,          
             'delivery_address'  => $request->delivery_address,          
             'delivery_number'   => $request->delivery_number,          
             'delivery_zip_code' => $request->delivery_zip_code,          
             'delivery_district' => $request->delivery_district,          
             'delivery_city'     => $request->delivery_city,          
             'delivery_state'    => $request->delivery_state,          
             'delivery_fone'     => $request->delivery_fone,          
             'delivery_fone2'    => $request->delivery_fone2,          
            );
             //insere o cabecalho dos dados da entrada
            //  dd($cabecalho);    
            orcamento::find($id)->update($cabecalho);

        //trás os itens do orçamento
        $data = []; 
        foreach($request->product_id as $key => $result ){  
 
            $explode1 = explode('[', $request->product_id[$key]);
            $explode2 = explode(']',$explode1[1]);
            $codproduto = trim($explode2[0]);                 
          
	    $data = array(
            'orcamento_id'    => $id,
            'product_id'      => $codproduto,
            'quantity'        => $request->quantity[$key],
            'unit_price'      => $request->price[$key],            
            'subtotal'        => $request->total[$key],
            'largura'         => $request->largura[$key],
            'espessura'       => $request->espessura[$key],
            'comprimento'     => $request->comprimento[$key],
            'qtde_quadrado'   => $request->qtde_quadrado[$key],
            'total_quadrado'  => $request->total_quadrado[$key],                       
        ); 

        //insere os produtos da entrada de produtos
        orcamentoitens::create($data);     
     }    
        return redirect("/Orcamento/Editar/$id")->with('update_message','Post was update!');  
    } 

    public function GerarPedido(Request $request, $id){

        // dd($id);

        orcamento::find($id)->update(['aprovado' => 'S']);

        return redirect("/Pedido/Editar/$id")->with('gerar_pedido_message','Post was update!');  

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
