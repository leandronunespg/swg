<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;



class empresas extends Model
{
       

    use Sortable;
    // use SoftDeletes;
    use HasFactory;

    public $table = 'empresas';
    
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';

    // protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public function FormatData() {
        return substr($this->date,8,2)."/".substr($this->date,5,2)."/".substr($this->date,0,4);
    }
    public function FormatCnpj() {
        return substr($this->cnpj,0,2).".".substr($this->cnpj,2,3).".".substr($this->cnpj,5,3).".".substr($this->cnpj,8,4)."-".substr($this->cnpj,12,2);
    }   
    public function Entidades() {
        return entidades::where('id',$this->entidade_id)->first()->name;
    }
    
    public function Usuario() {
        return User::where('id',$this->user_id)->first()->name;
    }
    
    
    public $fillable = ['id',
                        'logo',
                        'name',
                        'razao_social',
                        'cnpj',
                        'ie',
                        'address',
                        'number_address',
                        'district',
                        'city',
                        'state',
                        'tel',
                        'footer',
                        'cep_emitente'
                        ];
}