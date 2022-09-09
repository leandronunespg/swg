<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use App\Models\formapagamento;



class pedido extends Model
{
       

    use Sortable;
    use SoftDeletes;
    use HasFactory;

    public $table = 'pedidos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public function FormatData() {
        return substr($this->date,8,2)."/".substr($this->date,5,2)."/".substr($this->date,0,4);
    }         
    public function CentroCusto() {
        return centrocusto::where('id',$this->centrocusto_id)->first()->name;
    }
    public function FormaPagamento() {
        return formapagamento::where('id',$this->formapagamento_id)->first()->name;
    }
    public function Historico() {
        return historico::where('id',$this->historico_id)->first()->name;
    }
    public function Entidades() {
        return entidades::where('id',$this->entidade_id)->first()->name;
    }
    
    public function Usuario() {
        return User::where('id',$this->user_id)->first()->name;
    }
    
    
    public $fillable = ['id',
                        'date',
                        'entidade_id',
                        'user_id',
                        'total',
                        'aprovado',
                        'product_discount',
                        'total_discount',
                        'grand_total',
                        'quantity_items',
                        'total_items',
                        'note',
                        'status',
                        'cpf',
                        'cnpj',
                        'nfe',
                        'natureza_operacao',
                        'tipo_documento',
                        'valor_frete',
                        'valor_seguro',
                        'finalidade_emissao',
                        'modalidade_frete',
                        'cfop',
                        'local_destino',
                        'numero',
                        'receita',
                        'vencimento',
                        'chave',
                        'outras_despesas'];
}