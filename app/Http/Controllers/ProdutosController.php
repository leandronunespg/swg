<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produtos;
use App\Models\categorias;
use App\Models\tipoentidades;
use App\Models\tabelas;
use App\Models\estoque;


class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        $ResultProdutos = produtos::all();

        $TabelaPreco = [];
        foreach($ResultProdutos as $key => $result){
            $Tabela = $this->tabelaPrecos($result->id);
            $TabelaPreco["Items"][$key] = $Tabela;
        }
       
        $TabelaEstoque = [];
        foreach($ResultProdutos as $key => $result){
            $Estoque = $this->tabelaEstoque($result->id);
            $TabelaEstoque["Items"][$key] = $Estoque;
        }
  
        return view('produtos', compact('ResultProdutos','TabelaPreco','TabelaEstoque'));
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        
        $ResultTipoEntidades = tipoentidades::where('code','>','0')->get(); 
        $ResultCategorias = categorias::all();
        $ResultTabelas = "";

        return view('formprodutos',compact('ResultCategorias','ResultTipoEntidades','ResultTabelas'));        
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

        produtos::create($Dados);
        return redirect()->route('produtos.index');               
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
        $ResultProdutos = produtos::where('id',$id)->first(); 
        $ResultCategorias = categorias::all();            
        $ResultTipoEntidades = tipoentidades::where('code','>','0')->get(); 
        $ResultTabelas = tabelas::where('product_id',$id)->get(); 
        $ResultEstoque = estoque::selectRaw('SUM(quantity) as SaldoAtual')->where('product_id',$id)->orderBy('id','desc')->groupBy('product_id')->first(); 
        
                
        return view('/formprodutos', compact('ResultProdutos','ResultCategorias','ResultTipoEntidades','ResultTabelas','ResultEstoque'));
    }

    public function table(Request $request)
    {
        $tipoentidade_id  = $request->tipoentidade_id;
        $product_id       = $request->product_id;
        $PriceTabela      = $request->PriceTabela;
        
        //tabelas::find($id)->update(['payday' => $DataPagamento,'status' => 'P']);
        $Dados = array(
            'tipoentidade_id'   => $request->tipoentidade_id,
            'product_id'        => $request->product_id,
            'price'             => $request->PriceTabela
        );
        
       // dd($Dados["price"]);
        tabelas::create($Dados);

        return redirect('Produtos/Editar/'.$product_id)->with('pay_message','Post was update!');
    }


    public function tableDestroy($id,$product_id)
    {
        $ResultTabela = tabelas::where('id',$id)->delete();        
        return redirect('Produtos/Editar/'.$product_id)->with('deleted_message','Deleted!');
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
        produtos::find($id)->update($Dados);
        return redirect("/Produtos")->with('success_message','Post was created!');          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ResultProdutos = produtos::where('id',$id)->delete();        
        return redirect("/Produtos")->with('deleted_message','Post was deleted!');  
    }

     //traz a tabela de preços
     public function tabelaPrecos($id)
     {              
         $ResultTabelas = tabelas::where('product_id',$id)->get();
         return $ResultTabelas;
     }    
     
     //traz a tabela de estoque
     public function tabelaEstoque($id)
     {              
         $ResultEstoque = estoque::selectRaw('SUM(quantity) as SaldoAtual')->where('product_id',$id)->orderBy('id','desc')->groupBy('product_id')->get();
         return $ResultEstoque;
     }    
 
    
}
