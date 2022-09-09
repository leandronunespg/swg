<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tipoentidades;
use Illuminate\Database\Eloquent\SoftDeletes;

class entidades extends Model
{

    public function FormatTelefone() {
        return "(".substr($this->fone,0,2).") ".substr($this->fone,2,5)."-".substr($this->fone,7,10);
    }
    
    public function FormatData() {
        return substr($this->date,8,2)."/".substr($this->date,5,2)."/".substr($this->date,0,4);
    }
    
    public function FormatTipo() {
        return tipoentidades::where('id',$this->tipoentidade_id)->first()->name;
    }
    
    use SoftDeletes;
    use HasFactory;

    public $table = 'entidades';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $fillable = ['tipoentidade_id',
                        'type',
                        'name',
                        'razao',
                        'address',
                        'number',
                        'city',
                        'district',
                        'state',
                        'zip_code',
                        'fone',
                        'fone2',
                        'email',
                        'branch_activity',//ramo de atividade
                        'area_activity',
                        'profession',
                        'cpf',
                        'cnpj',
                        'pis',
                        'ie',
                        'rg',
                        'cad_pro',
                        'nationality',
                        'dad',
                        'mother',
                        'dependent1',
                        'dependent2',
                        'dependent3',
                        'dependent4',
                        'dependent5',
                        'dependent6',
                        'status'];

}
