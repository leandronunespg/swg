<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;



class entradaitens extends Model
{     
    public function Product() {
        return Produtos::where('id',$this->product_id)->first()->name;
    }
    
    use Sortable;
    use SoftDeletes;
    use HasFactory;

    public $table = 'entradaitens';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['entrada_id',
                        'product_id',
                        'quantity',
                        'price',
                        'total',
                        'largura',
                        'espessura',
                        'comprimento',
                        'qtde_quadrado',
                        'total_quadrado'];
}