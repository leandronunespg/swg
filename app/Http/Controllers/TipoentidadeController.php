<?php

namespace App\Http\Controllers;

use App\Models\tipoentidades;
use Illuminate\Http\Request;

class TipoentidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ResultTipoEntidade = tipoentidades::all();       
        return view('tipoentidade', compact('ResultTipoEntidade'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ResultTipoEntidadeCode = tipoentidades::orderBy('code','DESC')->first();
        $ResultTipoEntidade = ""; 
        return view('formtipoentidade',compact('ResultTipoEntidade','ResultTipoEntidadeCode'));
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
        tipoentidades::create($Dados);
        return redirect()->route('tipoentidade.index')->with('success_message','Post was created!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tipoentidades  $tipoentidades
     * @return \Illuminate\Http\Response
     */
    public function show(tipoentidades $tipoentidades)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tipoentidades  $tipoentidades
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ResultTipoEntidade = tipoentidades::where('id',$id)->first();   
        return view('/formtipoentidade', compact('ResultTipoEntidade'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tipoentidades  $tipoentidades
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Dados = $request->all();        
        tipoentidades::find($id)->update($Dados);
        return redirect()->route('tipoentidade.index')->with('update_message','Post was update!');         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tipoentidades  $tipoentidades
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultTipoEntidade = tipoentidades::where('id',$id)->delete();        
        return redirect()->route('tipoentidade.index')->with('deleted_message','Post was deleted!'); 
    }
}
