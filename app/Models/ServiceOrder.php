<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table = 'cao_os';

    protected $primaryKey = "co_os";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nu_os', 'co_sistema', 'co_usuario', 'co_arquitectura', 'ds_os', 'ds_caracteristica', 'ds_requisito', 'dt_inicio', 'dt_fim', 'co_status', 'directoria_sol', 'dt_sol', 'nu_te_sol', 'ddd_tel_sol', 'nu_tel_sol2', 'ddd_tel_sol2', 'usuario_sol', 'dt_imp', 'dt_garantia', 'co_email', 'co_os_prospect_rel'
    ];

    /**
     * Retrieves all users with consultant permissions.
     */
    public function consultant(){
    	return $this->belongsTo('App\Models\User', 	// Table
 								'co_usuario');		// Destination FK
    }

    /**
     * Retrieves the invoice assigned to the service order.
     */
    public function invoices(){
    	return $this->hasMany('App\Models\Invoice',
    							'co_os'); // Model
 								
    }
}
