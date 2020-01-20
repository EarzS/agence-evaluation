<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SystemPermission extends Model
{
	protected $table = 'permissao_sistema';

	/**
	 * Composite primary key https://blog.maqe.com/solved-eloquent-doesnt-support-composite-primary-keys-62b740120f
	 */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('co_usuario', '=', $this->getAttribute('co_usuario'))
            ->where('co_tipo_usuario', '=', $this->getAttribute('co_tipo_usuario'))
            ->where('co_sistema', '=', $this->getAttribute('co_sistema'));

        return $query;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'in_ativo', 'co_usuario_atualizacao', 'dt_aualizacao'
    ];
}
