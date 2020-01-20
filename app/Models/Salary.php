<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'cao_salario';

    protected $primaryKey = "co_usuario";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dt_alteracao', 'brut_salario', 'liq_salario'
    ];

    /**
     * Retrieves all service orders made by a consultant
     */
    public function user(){
        return $this->hasOne('App\Models\User',     // Model 
                              'co_usuario');        // Destination FK
    }
}
