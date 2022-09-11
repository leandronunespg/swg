<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use PDF;
use App\Models\lancamento;
use App\Models\centrocusto;
use App\Models\historico;
use App\Models\entidades;
use App\Models\formapagamento;
use App\Models\produtos;
use App\Models\User;
use App\DataTables\LancamentoDataTable;
use App\Models\orcamento;
use App\Models\orcamentoitens;
use App\Models\entradaitens;
use App\Models\pedido;
use App\Models\pedidoitems;
use App\Models\empresas;
use App\Models\entradaproduto;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GerarOrcamento($id){

        $ResultEmpresa           = empresas::first();
        $ResultEntidade          = entidades::all();
        $ResultUser              = User::all();
        $ResultOrcamento         = orcamento::where('id',$id)->first();
        $ResultItensOrcamento    = orcamentoitens::where('orcamento_id',$id)->get();
        $ResultFormaPagamento    = formapagamento::all();
               
          
        $pdf = PDF::loadView('printorcamento', compact('ResultOrcamento','ResultEmpresa','ResultItensOrcamento','ResultUser','ResultEntidade'));
        $id = str_pad($id , 5 , '0' , STR_PAD_LEFT);
        return $pdf->setPaper('A4')->stream("Orcamento_$id.pdf");
    }
    
    public function GerarPedido($id){

        $ResultEmpresa           = empresas::first();
        $ResultEntidade          = entidades::all();
        $ResultUser              = User::all();
        $ResultPedido            = pedido::where('id',$id)->first();
        $ResultItemsPedido       = pedidoitems::where('pedido_id',$id)->get();
        $ResultCentroCusto       = centrocusto::orwhere('name','like','vendas')->get();
        $ResultHistorico         = historico::where('centrocusto_id',$ResultPedido->centrocusto_id)->get();
        $ResultFormaPagamento    = formapagamento::all();
        $ResultLancamento        = lancamento::where('pedido_id',$id)->get();
               
          
        $pdf = PDF::loadView('printpedido', compact('ResultEmpresa','ResultEntidade','ResultUser','ResultPedido','ResultItemsPedido','ResultCentroCusto','ResultHistorico','ResultFormaPagamento','ResultLancamento'));
        $id = str_pad($id , 5 , '0' , STR_PAD_LEFT);
        return $pdf->setPaper('A4')->stream("Pedido_$id.pdf");
    }
    
    public function GerarCompra($id){

        $ResultEmpresa           = empresas::first();
        $ResultUser              = User::all();
        $ResultEntrada           = entradaproduto::where('id',$id)->first();
        $ResultItemsEntrada      = entradaitens::where('entrada_id',$id)->get();
        $ResultCentroCusto       = centrocusto::orwhere('name','like','vendas')->get();
        $ResultEntidade          = entidades::where('id',$ResultEntrada->entidade_id)->first();
        $ResultHistorico         = historico::where('centrocusto_id',$ResultEntrada->centrocusto_id)->get();
        $ResultFormaPagamento    = formapagamento::all();
        $ResultLancamento        = lancamento::where('entradaproduto_id',$id)->get();
               
        //dd($ResultItemsEntrada);
          
        $pdf = PDF::loadView('printcompra', compact('ResultEmpresa','ResultEntidade','ResultUser','ResultEntrada','ResultItemsEntrada','ResultCentroCusto','ResultHistorico','ResultFormaPagamento','ResultLancamento'));
        $id = str_pad($id , 5 , '0' , STR_PAD_LEFT);
        return $pdf->setPaper('A4')->stream("Compra_$id.pdf");
    }
}