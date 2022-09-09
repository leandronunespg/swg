<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class PrintOrcamentoController extends Controller
{
    public function printOrcamento($id){        
      
        $ResultEntidade          = entidades::all();
        $ResultUser              = User::all();
        $ResultOrcamento         = orcamento::where('id',$id)->first();
        $ResultItensOrcamento    = orcamentoitens::where('orcamento_id',$id)->get();
        $ResultFormaPagamento    = formapagamento::all();        
        
        return view('formorcamento', compact('ResultOrcamento','ResultItensOrcamento','ResultUser','ResultEntidade'));
    }
}
