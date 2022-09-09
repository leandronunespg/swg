<?php

namespace App\Http\Controllers;

use App\Models\categorias;
use App\Models\tipoentidades;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ResultCategorias = categorias::all();       
        return view('categorias', compact('ResultCategorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ResultCategorias = "";
        $ResultCategoriasCode = categorias::orderBy('code','DESC')->first();
        return view('formcategorias',compact('ResultCategorias','ResultCategoriasCode'));   
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
        return redirect()->route('categorias.index')->with('success_message','Post was created!'); 
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
        $ResultCategoriasCode = ""; 
        return view('formcategorias', compact('ResultCategorias','ResultCategoriasCode'));
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
        return redirect()->route('categorias.index')->with('update_message','Post was update!');         
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
        return redirect()->route('categorias.index')->with('deleted_message','Post was deleted!'); 
    }
}
