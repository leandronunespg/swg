<?php

namespace App\Http\Controllers;

use App\Models\lancamento;
use App\Models\centrocusto;
use App\Models\historico;
use App\Models\entidades;
use App\Models\formapagamento;
use App\Models\tipoentidades;
use App\Models\User;
use App\Models\pagamento;
use Illuminate\Http\Request;
use App\DataTables\LancamentoDataTable;

class PagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id  = $request->id;

        $resposta = [];
        $lancamento = lancamento::where("id", $id)->get();                     

        if (!empty($lancamento)) {
              
            foreach ($lancamento as $key => $registros){

                    $vencimento = substr($registros->date,8,2)."/".substr($registros->date,5,2)."/".substr($registros->date,0,4);
                    //$ValorNota   = number_format("$Registros->T007_Valor_Total",2,",",".");
                            
                $resposta = array(        
                    'cod_pagamento'      => $registros->id,
                    'data_vencimento'    => $registros->date,
                    'valor_vencimento'   => $registros->price,                                                                                                                                                    
                );
            }
            //dd($resposta);
            return $resposta;
        }
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }
          
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $DataPagamento = date("Y-m-d");
        $id       = $request->cod_pagamento;
        $banco_id = $request->banco_id;
        $formapagamento_id = $request->formapagamento_id;
        $valor    = $request->valor_pagamento; 
        $status   = $request->status;    

        lancamento::find($id)->update(['payday' => $DataPagamento,'status' => "P",'banco_id' => $banco_id,'formapagamento_id' => $formapagamento_id]);
          
        pagamento::create(['lancamento_id'=>$id,'price'=>$valor,'payday'=>$DataPagamento]);

        return redirect('Lancamentos/'.$status)->with('pay_message','Post was update!'); 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function show(lancamento $lancamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $ResultLancamento = lancamento::where('id',$id)->get();    
        return view('updatelancamento', compact('ResultLancamento','ResultCentroCusto','ResultHistorico','ResultEntidade','ResultFormaPagamento'));
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
        return redirect()->route('lancamentos.index');    
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
        return redirect()->route('lancamentos.index'); 
    }
}
