<?php

namespace App\Http\Controllers;

use App\Models\centrocusto;
use Illuminate\Http\Request;

class CentrocustoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ResultCentroCusto = centrocusto::all();
        return view('centrocusto', compact('ResultCentroCusto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ResultCentroCusto = centrocusto::all();
        return view('formcentrocusto',compact('ResultCentroCusto'));   
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
        centrocusto::create($Dados);
        return redirect()->route('centrocusto.index')->with('success_message','Post was created!');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\centrocusto  $centrocusto
     * @return \Illuminate\Http\Response
     */
    public function show(centrocusto $centrocusto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\centrocusto  $centrocusto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ResultCentroCusto   = centrocusto::where('id',$id)->get();       
        return view('updatecentrocusto', compact('ResultCentroCusto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\centrocusto  $centrocusto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Dados = $request->all();        
        centrocusto::find($id)->update($Dados);
        return redirect()->route('centrocusto.index')->with('update_message','Post was update!');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\centrocusto  $centrocusto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultCentroCusto = centrocusto::where('id',$id)->delete();        
        return redirect()->route('centrocusto.index')->with('deleted_message','Post was deleted!'); 
    }
}
