<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\centrocusto;

class historico extends Model
{

    public function CentroCusto() {
        return centrocusto::where('id',$this->centrocusto_id)->first()->name;
    }
    
    use SoftDeletes;
    use HasFactory;

    public $table = 'historicos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['centrocusto_id',
                        'name',
                        'status'];

}
