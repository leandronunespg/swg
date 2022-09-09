<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\categorias;

class produtos extends Model
{
    public function FormatCategoria() {
        return categorias::where('id',$this->category_id)->first()->name;
    }

    use SoftDeletes;
    use HasFactory;

    public $table = 'produtos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['id',
                        'code',
                        'name',
                        'category_id',
                        'cfop',
                        'natureza_operacao',
                        'icms_situacao_tributaria',
                        'icms_origem',
                        'unidade_comercial',
                        'price',
                        'image',
                        'tax',
                        'cost',
                        'tax_method',
                        'quantity',
                        'barcode_symbology',
                        'type',
                        'details',
                        'alert_quantity',
                        'ncm'];

}
