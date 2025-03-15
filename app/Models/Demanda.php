<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Demanda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'demandas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        '_id',
        'origem_id',
        'solicitante_id',
        'categoria_id',
        'subcategoria_id',
        'recebido_por_agente_id',
        'status_id',
        'grupo_solucao_id',
        'agente_solucao_id',
    ];

    public function origem()
    {
        return $this->hasOne(Origem::class, 'origem_id');
    }

    public function solicitante()
    {
        return $this->hasOne(Solicitante::class, 'solicitante_id');
    }

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'categoria_id');
    }

    public function agentePrimeiroAtendimento()
    {
        return $this->hasOne(Agente::class, 'recebido_por_agente_id');
    }

    public function grupoDeSolucao()
    {
        return $this->hasOne(GrupoSolucao::class, 'grupo_solucao_id');
    }

    public function agenteDeSolucao()
    {
        return $this->hasOne(Agente::class, 'agente_solucao_id');
    }

}
