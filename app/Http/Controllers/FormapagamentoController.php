<?php

namespace App\Http\Controllers;

use App\Models\formapagamento;
use Illuminate\Http\Request;

class FormapagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ResultFormaPagamento = formapagamento::all();
        return view('formapagamento', compact('ResultFormaPagamento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ResultFormaPagamento = formapagamento::all();
        return view('formformapagamento',compact('ResultFormaPagamento'));
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
        formapagamento::create($Dados);
        return redirect()->route('formapagamento.index')->with('success_message','Post was created!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\formapagamento  $formapagamento
     * @return \Illuminate\Http\Response
     */
    public function show(formapagamento $formapagamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\formapagamento  $formapagamento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ResultFormaPagamento   = formapagamento::where('id',$id)->get();       
        return view('updateformapagamento', compact('ResultFormaPagamento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\formapagamento  $formapagamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Dados = $request->all();        
        formapagamento::find($id)->update($Dados);
        return redirect()->route('formapagamento.index')->with('update_message','Post was update!');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\formapagamento  $formapagamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultFormaPagamento = formapagamento::where('id',$id)->delete();        
        return redirect()->route('formapagamento.index')->with('deleted_message','Post was deleted!'); 
    }
}
