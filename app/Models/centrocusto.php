<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\caixa;

class centrocusto extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'centrocustos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public function Caixas() {
        return $this->hasMany(caixa::class,'centrocusto_id');
    }

    public $fillable = ['name',
                        'status'];
}
