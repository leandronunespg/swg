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

class caixa extends Model
{

    public function Banco() {
        return entidades::where('id',$this->banco_id)->first()->name;
    }
    public function Entidade() {
        return entidades::where('id',$this->entidade_id)->first()->name;
    }
   
    public function Lancamento() {
        return lancamento::where('id',$this->lancamento_id)->first()->name;
    }
    public function CentroCusto() {
        return $this->belongsTo(centrocusto::class,'centrocusto_id');
    }
    public function Historico() {
        return historico::where('id',$this->historico_id)->first()->name;
    }
    public function User() {
        return user::where('id',$this->user_id)->first()->name;
    }
    
    use SoftDeletes;
    use HasFactory;

    public $table = 'caixas';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['banco_id',
                        'entidade_id',
                        'pedido_id',
                        'lancamento_id',
                        'centrocusto_id',
                        'historico_id',
                        'price',
                        'observation',                        
                        'date',
                        'user_id'];

}
