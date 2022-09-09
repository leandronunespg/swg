<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tipoentidades;
use App\Models\entidades;
use App\Models\formapagamento;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;



class lancamento extends Model
{
    public function FormatTelefone() {
        return "(".substr($this->fone,0,2).") ".substr($this->fone,2,5)."-".substr($this->fone,7,10);
    }
    
    public function FormatData() {
        return substr($this->date,8,2)."/".substr($this->date,5,2)."/".substr($this->date,0,4);
    }
    public function CentroCusto() {
        return centrocusto::where('id',$this->centrocusto_id)->first()->name;
    }
    public function FormaPagamento() {
        return @formapagamento::where('id',$this->formapagamento_id)->first()->name;
    }
    public function Historico() {
        return historico::where('id',$this->historico_id)->first()->name;
    }
    public function Entidades() {
        return entidades::where('id',$this->entidade_id)->first()->name;
    }
    public function Usuario() {
        return User::where('id',$this->user_id)->first()->name;
    }
    public function FormatTipo() {
        return tipoentidades::where('id',$this->tipoentidade_id)->first()->name;
    }
  
    use Sortable;
    use SoftDeletes;
    use HasFactory;

    public $table = 'lancamentos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['centrocusto_id',
                        'historico_id',
                        'entidade_id',
                        'user_id',
                        'type',
                        'pedido_id',
                        'entradaproduto_id',
                        'formapagamento_id',
                        'banco_id',
                        'price',
                        'date',
                        'due_date',
                        'payday',
                        'note',
                        'status'];

    public $sortable = ['centrocusto_id',
                        'historico_id',
                        'entidade_id',
                        'user_id',
                        'formapagamento_id',
                        'price',
                        'date'
                       ];
}
