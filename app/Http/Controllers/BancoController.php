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
use App\Models\banco;
use Illuminate\Http\Request;
use App\DataTables\LancamentoDataTable;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $id  = $request->id;                

        $ResultUser       = User::all();
        $entidade_id      = $request->entidade_id;
        $data_inicio      = $request->data_inicio;
        $data_final       = $request->data_final;
        
                
        $ResultBanco = banco::select('id','entidade_id','price','date');

        $Total = banco::selectRaw('SUM(price) as Total');
        
        if($entidade_id == true){
            $Total = $Total->where('user_id',$entidade_id);
            $ResultLancamento = $ResultBanco->where('user_id',$entidade_id);
        }
        if($data_inicio == true){
            $Total = $Total->whereBetween('date',[$data_inicio,$data_final]);
            $ResultBanco = $ResultBanco->whereBetween('date',[$data_inicio,$data_final]);
            
        }

        $Total = $Total->where("entidade_id",$entidade_id)->first();
        $ResultBanco = $ResultBanco->where("entidade_id",$entidade_id)->get(); 
                                       

         return view('banco', compact('ResultBanco','ResultUser','Total'));
            
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
}
