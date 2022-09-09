<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;



class orcamento extends Model
{
       

    use Sortable;
    use SoftDeletes;
    use HasFactory;

    public $table = 'orcamentos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public function FormatData() {
        return substr($this->date,8,2)."/".substr($this->date,5,2)."/".substr($this->date,0,4);
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
                        'date_aprovacao',
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
                        'outras_despesas',
                        'delivery_address',
                        'delivery_number',
                        'delivery_fone',
                        'delivery_fone2',
                        'delivery_district',
                        'delivery_city',
                        'delivery_state',
                        'delivery_zip_code'
                    ];
}