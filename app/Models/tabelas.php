<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tabelas extends Model
{

    public function FormatTabela() {
        return tipoentidades::where('code',$this->tipoentidade_id)->first()->name;
    }

    use SoftDeletes;
    use HasFactory;

    public $table = 'tabela_precos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['tipoentidade_id',
                        'product_id',
                        'price',
                        'PercentualTabela'];

}
