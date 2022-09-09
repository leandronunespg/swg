<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;



class pedidoitems extends Model
{     
    public function Product() {
        return Produtos::where('id',$this->product_id)->first()->name;
    }
    
    use Sortable;
    use SoftDeletes;
    use HasFactory;

    public $table = 'pedidoitems';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['pedido_id',
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
                        'siagro'];
}