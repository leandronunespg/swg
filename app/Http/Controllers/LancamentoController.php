<?php

namespace App\Http\Controllers;

use App\Models\lancamento;
use App\Models\centrocusto;
use App\Models\historico;
use App\Models\entidades;
use App\Models\formapagamento;
use App\Models\tipoentidades;
use App\Models\User;
use App\DataTables\LancamentoDataTable;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Carbon;

class LancamentoController extends Controller
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
    
    public function RetornaMes($intervalo){
        $Inicio    = Carbon::now()->addMonth($intervalo)->format('Y-m-01');
        $Termino   = Carbon::now()->addMonth($intervalo)->format('Y-m-t');
    
        return $Inicio.$Termino;   
    }

    public function index(Request $request){
        $ResultUser       = User::all();
        $status           = $request->status;
        $type             = $request->type;
        $user_id          = $request->user_id;
        $data_inicio      = $request->data_inicio;
        $data_final       = $request->data_final;
                
        $ResultBanco      = entidades::select('entidades.name','entidades.id')
                                  ->where('tipoentidades.name','like','%banco%')
                               ->leftJoin('tipoentidades','tipoentidades.id','entidades.tipoentidade_id')
                                ->orderBy('entidades.name','asc')
                                    ->get(); 
        $ResultFormaPagamento    = formapagamento::all();

        $ResultLancamento = lancamento::select('id','type','centrocusto_id','historico_id','entidade_id','user_id','price','formapagamento_id','date');

        $Total = lancamento::selectRaw('SUM(price) as Total');
         
        $ResultLancamento = $ResultLancamento->where('type',$type);

        if($user_id == true){
            $Total = $Total->where('user_id',$user_id);
            $ResultLancamento = $ResultLancamento->where('user_id',$user_id);
        }

        if($data_inicio == true){
            if($status == "P"){
                $Total = $Total->whereBetween('payday',[$data_inicio,$data_final]);
                $ResultLancamento = $ResultLancamento->whereBetween('payday',[$data_inicio,$data_final]);
            }else{
                $Total = $Total->whereBetween('date',[$data_inicio,$data_final]);
                $ResultLancamento = $ResultLancamento->whereBetween('date',[$data_inicio,$data_final]);
            }
        }
       
        if($status == true){
            $Total = $Total->where('status',$status);
            $ResultLancamento = $ResultLancamento->where('status',$status);            
        }else{
            $Total = $Total->where('status','A');
            $ResultLancamento = $ResultLancamento->where('status','A');
        }

        $Total = $Total->first();
        $ResultLancamento = $ResultLancamento->get(); 
                                       

         return view('lancamento', compact('ResultBanco','ResultFormaPagamento','ResultLancamento','ResultUser','Total','data_inicio','data_final','status','type','user_id'));
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $ResultLancamento        = lancamento::all();
        $ResultCentroCusto       = centrocusto::all();
        $ResultHistorico         = historico::all();
        $ResultEntidade          = entidades::all();
        $ResultFormaPagamento    = formapagamento::all();
        $ResultUser              = User::all();
        
       
        //dd($ResultUser);
         return view('formlancamento',compact('ResultLancamento','ResultCentroCusto','ResultHistorico','ResultEntidade','ResultFormaPagamento','ResultUser'));   
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
        $Dia = substr($request->date,8,2); 
        $Mes = substr($request->date,5,2); 
        $Ano = substr($request->date,0,4);       
        $Qtd = $request->qtd;  

        $data = [];
        for($x=0;$x<$Qtd;$x++){            
        $FormatarReplicacao =  mktime(0,0,0,$Mes+$x,$Dia,$Ano);
	    $data = array(
            "centrocusto_id"    => $request->centrocusto_id,
            "historico_id"      => $request->historico_id,
            "entidade_id"       => $request->entidade_id,
            "user_id"           => $request->user_id,
            "type"              => $request->type,
            "price"             => $request->price,
            "formapagamento_id" => $request->formapagamento_id,
            "date"              => date("Y-m-d", $FormatarReplicacao),
        );  
        lancamento::create($data);     
    }    
        return redirect("/Lancamentos/A/")->with('success_message','Post was created!');  
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
        $ResultCentroCusto       = centrocusto::all();
        $ResultHistorico         = historico::all();
        $ResultEntidade          = entidades::all();
        $ResultFormaPagamento    = formapagamento::all();
        $ResultLancamento        = lancamento::where('id',$id)->get();    
        $ResultUser              = User::all();
        return view('updatelancamento', compact('ResultLancamento','ResultUser','ResultCentroCusto','ResultHistorico','ResultEntidade','ResultFormaPagamento'));
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
