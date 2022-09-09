<?php

namespace App\Http\Controllers;

use App\Models\historico;
use App\Models\centrocusto;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ResultHistorico = historico::all();       
        return view('historico', compact('ResultHistorico'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ResultHistorico = historico::all();
        $ResultCentroCusto = centrocusto::all();
        return view('formhistorico',compact('ResultHistorico','ResultCentroCusto'));   
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
        historico::create($Dados);
        return redirect()->route('historico.index')->with('success_message','Post was created!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\historico  $historico
     * @return \Illuminate\Http\Response
     */
    public function show(historico $historico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\historico  $historico
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ResultHistorico = historico::where('id',$id)->get(); 
        $ResultCentroCusto = centrocusto::all();       
        return view('updatehistorico', compact('ResultHistorico','ResultCentroCusto'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\historico  $historico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Dados = $request->all();        
        historico::find($id)->update($Dados);
        return redirect()->route('historico.index')->with('update_message','Post was update!');         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\historico  $historico
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultHistorico = historico::where('id',$id)->delete();        
        return redirect()->route('historico.index')->with('deleted_message','Post was deleted!'); 
    }
}
