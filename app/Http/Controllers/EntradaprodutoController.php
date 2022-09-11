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
use App\Models\entradaproduto;
use App\Models\entradaitens;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Carbon;

class EntradaprodutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function DashBoard(){
        $Datas = [];

        for($x=0;$x<=6;$x++){
            $Start  = substr($this->RetornaMes(-$x),0,10);
            $End    = substr($this->RetornaMes(-$x),10,10);
            $Indice = substr($this->RetornaMes(-$x),5,2)."/".substr($this->RetornaMes(-$x), 0,4);
            
            $Datas[$Indice] = $this->PagamentoAnual($Start,$End);
           
        }
             
        return view('dashboard',compact('Datas'));               
        
    }
    
    public function home(){

        $MesAtual       = date('M/y', strtotime('0 months', strtotime(date('Y-m-d'))));    
        $MesProximo     = date('M/y', strtotime('+1 months', strtotime(date('Y-m-d'))));    
        $MesSubsequente = date('M/y', strtotime('+2 months', strtotime(date('Y-m-d'))));    
       
        //Total a pagar mês atual
        $TotalPago      = lancamento::select('price')
                                        ->whereBetween('payday',[substr($this->RetornaMes(0),0,10) , substr($this->RetornaMes(0),10,10)])
                                        ->where('status','P')
                                        ->sum('price');

        //Total a pagar mês atual
        $TotalAPagar1    = lancamento::select('price')
                                        ->whereBetween('date',[substr($this->RetornaMes(0),0,10), substr($this->RetornaMes(0),10,10)])
                                        ->where('status','A')
                                        ->sum('price');

        //Total a pagar mês seguinte
        $TotalAPagar2    = lancamento::select('price')
                                        ->whereBetween('date',[substr($this->RetornaMes(1),0,10), substr($this->RetornaMes(1),10,10)])
                                        ->where('status','A')
                                        ->sum('price');

        //Total a pagar mês subsequente
        $TotalAPagar3    = lancamento::select('price')
                                        ->whereBetween('date',[substr($this->RetornaMes(2),0,10), substr($this->RetornaMes(2),10,10)])
                                        ->where('status','A')
                                        ->sum('price');                                          

        return view('calendariofinanceiro', compact('MesAtual','MesProximo','MesSubsequente','TotalPago','TotalAPagar1','TotalAPagar2','TotalAPagar3'));
    }

    public function PagamentoAnual($Start,$End){
        //Total a pagar mês atual
        $TotalPago      = lancamento::select('price')
                                        ->whereBetween('payday',[$Start, $End])
                                        ->where('status','P')
                                        ->sum('price');
            return $TotalPago;
    }
    
    public function consultaprodutos(Request $request){        
       
        $search = $request->search;
        
        if($search == ''){           
        $RegistroProdutos = [];
        }else{
        //Trás a relação de Clientes business_partners                
        $RegistroProdutos = produtos::where('name', 'like' ,'%'. $search .'%')
                                                        ->orderBy('name','asc')
                                                        ->limit('20')
                                                        ->get();              
                                                }
        
     
        $response = array();
        foreach($RegistroProdutos as $Registros){
            $response[] = array(
                'id'   => "[ ".$Registros->id." ] ".$Registros->name,
                'text' => "[ ".$Registros->id." ] ".$Registros->name
            );
        }
     
        return response()->json($response);
        
    }
    
    public function RetornaMes($intervalo){
        $Inicio    = Carbon::now()->addMonth($intervalo)->format('Y-m-01');
        $Termino   = Carbon::now()->addMonth($intervalo)->format('Y-m-t');
    
        return $Inicio.$Termino;   
    }

    public function index(Request $request){
           
        $ResultEntrada  = entradaproduto::all();

        return view('entradaproduto',compact('ResultEntrada')); 
                
    
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $ResultEntrada          = ""; //precisa passar vazio porque utilizo o form para cadastrar/editar
        $ResultCentroCusto      = centrocusto::all();
        $ResultHistorico        = historico::all();
        $ResultFormaPagamento   = formapagamento::all();
        $ResultEntidade         = entidades::select('entidades.name','entidades.id')
                                            ->where('tipoentidades.name','like','%fornecedor%')
                                         ->leftJoin('tipoentidades','tipoentidades.id','entidades.tipoentidade_id')
                                          ->orderBy('entidades.name','asc')
                                              ->get();   
        
         return view('formentradaprodutos',compact('ResultEntidade','ResultEntrada','ResultCentroCusto','ResultHistorico','ResultFormaPagamento')); 
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
             'valor_frete'       => $request->valor_frete,
             'total_nota'        => $request->total_nota,
             'total_items'       => $request->total_items,
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
            'type'                => 'D',
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
        $ResultLancamento        = lancamento::where('entradaproduto_id',$id)->get();    
        $ResultUser              = User::all();
        $ResultEntrada           = entradaproduto::where('id',$id)->first();
        $ResultItensEntrada      = entradaitens::where('entrada_id',$id)->get();
        $ResultCentroCusto       = centrocusto::all();
        $ResultHistorico         = historico::where('centrocusto_id',$ResultEntrada->centrocusto_id)->get();
        $ResultFormaPagamento    = formapagamento::all();

        // dd($ResultFormaPagamento);
        
        return view('formentradaprodutos', compact('ResultEntrada','ResultItensEntrada','ResultLancamento','ResultUser','ResultCentroCusto','ResultHistorico','ResultEntidade','ResultFormaPagamento'));
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
        $Dados = $request->all();  
   
        lancamento::find($id)->update($Dados);
        return redirect("/Lancamentos/A/")->with('update_message','Post was update!');      
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
