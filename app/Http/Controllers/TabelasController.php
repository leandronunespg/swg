<?php

namespace App\Http\Controllers;

use App\Models\tipoentidades;
use App\Models\tabelas;
use Illuminate\Http\Request;

class TabelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ResultTabelas = tabelas::all();       
        return view('tabelas', compact('ResultTabelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ResultTabelas = tabelas::all();
        return view('formtabelas',compact('ResultTabelas'));   
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
     * @param  \App\Models\tabelas  $tabelas
     * @return \Illuminate\Http\Response
     */
    public function show(tabelas $tabelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tabelas  $tabelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ResultTabelas = tabelas::where('id',$id)->first();
       //dd($Resulttabelas);  
        return view('formtabelas', compact('ResultTabelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tabelas  $tabelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Dados = $request->all();        
        tabelas::find($id)->update($Dados);
        return redirect()->route('tabelas.index');         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tabelas  $tabelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultTabelas = tabelas::where('id',$id)->delete();        
        return redirect()->route('tabelas.index'); 
    }
}
