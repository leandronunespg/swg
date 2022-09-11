<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class entradaproduto extends Model
{
       

    use Sortable;
    use SoftDeletes;
    use HasFactory;

    public $table = 'entradaprodutos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public function FormatData() {
        return substr($this->date,8,2)."/".substr($this->date,5,2)."/".substr($this->date,0,4);
    }
    public function CentroCusto() {
        return centrocusto::where('id',$this->centrocusto_id)->first()->name;
    }
    public function FormaPagamento() {
        return formapagamento::where('id',$this->formapagamento_id)->first()->name;
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
    public function Product() {
        return Produtos::where('id',$this->product_id)->first()->name;
    }

    public $fillable = ['entidade_id',
                        'entradaproduto_id',
                        'pedidovenda_id',
                        'formapagamento_id',
                        'centrocusto_id',
                        'historico_id',
                        'user_id',
                        'note_number',
                        'note',
                        'valor_frete',                        
                        'total_items',                        
                        'total_nota',                        
                        'date'];
}