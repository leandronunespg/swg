<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\entidades;
use App\Models\tipoentidades;
use App\Models\entradaproduto;
use App\Models\lancamento;
use App\Models\pedido;

class EntidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        $ResultEntidades = entidades::all();
        return view('entidades', compact('ResultEntidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        $ResultTipoEntidades = tipoentidades::all();
        return view('formentidades',compact('ResultTipoEntidades'));        
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
       // dd($Dados);

        entidades::create($Dados);
        return redirect()->route('entidades.index')->with('success_message','Post was created!');               
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ResultEntidades = entidades::where('id',$id)->first(); 
        $ResultTipoEntidades = tipoentidades::all();   
        $ResultCompras = entradaproduto::where('entidade_id',$id)->orderBy('date', 'desc')->get();   
        $ResultPedidos = pedido::where('entidade_id',$id)->orderBy('date', 'desc')->get();   
        $ResultFinanceiro = lancamento::where('entidade_id',$id)->orderBy('date', 'desc')->get();   
        
        return view('/formentidades', compact('ResultEntidades','ResultTipoEntidades','ResultCompras','ResultPedidos','ResultFinanceiro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Dados = $request->all();        
        entidades::find($id)->update($Dados);
        return redirect()->route('entidades.index')->with('update_message','Post was update!');         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultEntidades = entidades::where('id',$id)->delete();        
        return redirect()->route('entidades.index')->with('deleted_message','Post was deleted!'); 
    }
}
