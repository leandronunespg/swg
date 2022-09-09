<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;



class orcamentoitens extends Model
{     
    public function Product() {
        return Produtos::where('id',$this->product_id)->first()->name;
    }
    
    use Sortable;
    use SoftDeletes;
    use HasFactory;

    public $table = 'orcamentoitems';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['orcamento_id',
                        'product_id',
                        'quantity',
                        'unit_price',
                        'discount',
                        'item_discount',
                        'subtotal',
                        'real_unit_price',
                        'cost',
                        'cfop',
                        'icms_origem',
                        'siagro',
                        'largura',      
                        'espessura',    
                        'comprimento',  
                        'qtde_quadrado',
                        'total_quadrado'];
}