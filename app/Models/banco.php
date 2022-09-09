<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\entidades;
use App\Models\lancamento;
use App\Models\centrocusto;
use App\Models\historico;
use App\Models\user;

class banco extends Model
{      
    use SoftDeletes;
    use HasFactory;

    public $table = 'bancos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['id',
                        'name'];

}
