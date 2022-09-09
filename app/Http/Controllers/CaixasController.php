<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\banco;
use App\Models\entidades;
use App\Models\lancamento;
use App\Models\centrocusto;
use App\Models\historico;
use App\Models\user;
use App\Models\caixa;

class CaixasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banco_id                = @$_REQUEST['banco_id'];
        $entidade_id             = @$_REQUEST['entidade_id'];
        $pedido_id               = @$_REQUEST['pedido_id'];
        $lancamento_id           = @$_REQUEST['lancamento_id'];
        $centrocusto_id          = @$_REQUEST['centrocusto_id'];
        $historico_id            = @$_REQUEST['historico_id'];
        $user_id                 = @$_REQUEST['user_id'];
        $check_entrada           = @$_REQUEST['check_entrada'];
        $check_saida             = @$_REQUEST['check_saida'];
        $user_id                 = @$_REQUEST['user_id'];
        $data_inicio             = @$_REQUEST['date_inicio'];
        $data_final              = @$_REQUEST['date_final'];


        $ResultEntidade    = entidades::all();
        $ResultCentroCusto = centrocusto::all(); 
        $ResultBanco       = entidades::select('entidades.name','entidades.id')
                                       ->where('tipoentidades.name','like','%banco%')
                                    ->leftJoin('tipoentidades','tipoentidades.id','entidades.tipoentidade_id')
                                     ->orderBy('entidades.name','asc')
                                         ->get();

        $TotalCaixa   = caixa::whereBetween('caixas.date',[$data_inicio,$data_final]);  
        $TotalEntrada = caixa::whereBetween('caixas.date',[$data_inicio,$data_final])->where('caixas.price','>','0');  
        $TotalSaida   = caixa::whereBetween('caixas.date',[$data_inicio,$data_final])->where('caixas.price','<','0');  

        $ResultCaixa = caixa::whereBetween('caixas.date',[$data_inicio,$data_final])->with('CentroCusto');                            
        
        if($banco_id == true){
        $ResultCaixa = $ResultCaixa->where('caixas.banco_id',$banco_id);
        $TotalCaixa = $TotalCaixa->where('caixas.banco_id',$banco_id);
        $TotalEntrada = $TotalEntrada->where('caixas.banco_id',$banco_id);
        $TotalSaida = $TotalSaida->where('caixas.banco_id',$banco_id);
        }
        if($entidade_id == true){
        $ResultCaixa = $ResultCaixa->where('caixas.entidade_id',$entidade_id);
        $TotalCaixa = $TotalCaixa->where('caixas.entidade_id',$entidade_id);
        $TotalEntrada = $TotalEntrada->where('caixas.entidade_id',$entidade_id);
        $TotalSaida = $TotalSaida->where('caixas.entidade_id',$entidade_id);
        }
        if($pedido_id == true){
        $ResultCaixa = $ResultCaixa->where('caixas.pedido_id',$pedido_id);
        $TotalCaixa = $TotalCaixa->where('caixas.pedido_id',$pedido_id);
        $TotalEntrada = $TotalEntrada->where('caixas.pedido_id',$pedido_id);
        $TotalSaida = $TotalSaida->where('caixas.pedido_id',$pedido_id);
        }
        if($lancamento_id == true){
        $ResultCaixa = $ResultCaixa->where('caixas.lancamento_id',$lancamento_id);
        $TotalCaixa = $TotalCaixa->where('caixas.lancamento_id',$lancamento_id);
        $TotalEntrada = $TotalEntrada->where('caixas.lancamento_id',$lancamento_id);
        $TotalSaida = $TotalSaida->where('caixas.lancamento_id',$lancamento_id);
        }
        if($centrocusto_id == true){
        $ResultCaixa = $ResultCaixa->where('caixas.centrocusto_id',$centrocusto_id);
        $TotalCaixa = $TotalCaixa->where('caixas.centrocusto_id',$centrocusto_id);
        $TotalEntrada = $TotalEntrada->where('caixas.centrocusto_id',$centrocusto_id);
        $TotalSaida = $TotalSaida->where('caixas.centrocusto_id',$centrocusto_id);
        }
        if($historico_id == true){
        $ResultCaixa = $ResultCaixa->where('caixas.historico_id',$historico_id);
        $TotalCaixa = $TotalCaixa->where('caixas.historico_id',$historico_id);
        $TotalEntrada = $TotalEntrada->where('caixas.historico_id',$historico_id);
        $TotalSaida = $TotalSaida->where('caixas.historico_id',$historico_id);
        }
        if($user_id == true){
        $ResultCaixa = $ResultCaixa->where('caixas.user_id',$user_id);
        $TotalCaixa = $TotalCaixa->where('caixas.user_id',$user_id);
        $TotalEntrada = $TotalEntrada->where('caixas.user_id',$user_id);
        $TotalSaida = $TotalSaida->where('caixas.user_id',$user_id);
        }
        if($check_entrada == true){
        $ResultCaixa = $ResultCaixa->where('caixas.price', '>', '0');
        $TotalCaixa = $TotalCaixa->where('caixas.price','>','0');
        $TotalEntrada = $TotalEntrada->where('caixas.price','>','0');
        $TotalSaida = $TotalSaida->where('caixas.price','>','0');
        }
        if($check_saida == true){
        $ResultCaixa = $ResultCaixa->where('caixas.price','<','0');
        $TotalCaixa = $TotalCaixa->where('caixas.price','<','0');
        $TotalEntrada = $TotalEntrada->where('caixas.price','<','0');
        $TotalSaida = $TotalSaida->where('caixas.price','<','0');
        }

        $ResultCaixa = $ResultCaixa->get();

        $TotalCaixa = $TotalCaixa->sum('price');
        $TotalEntrada = $TotalEntrada->sum('price');
        $TotalSaida = $TotalSaida->sum('price');

        //dd($ResultCaixas);

        return view('/caixas', compact('ResultCaixa','ResultCentroCusto','ResultEntidade','TotalCaixa','ResultBanco','TotalEntrada','TotalSaida'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ResultCategorias = categorias::all();
        return view('formcategorias',compact('ResultCategorias'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Dados = $request->all();        
        categorias::create($Dados);
        return redirect()->route('categorias.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function show(categorias $categorias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ResultCategorias = categorias::where('id',$id)->first();
       //dd($ResultCategorias);  
        return view('formcategorias', compact('ResultCategorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Dados = $request->all();        
        categorias::find($id)->update($Dados);
        return redirect()->route('categorias.index');         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultCategorias = categorias::where('id',$id)->delete();        
        return redirect()->route('categorias.index'); 
    }
}
