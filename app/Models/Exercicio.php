<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercicio extends Model
{
    use HasFactory;

    protected $table = "exercicio";

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'materia',
        'tipo_exercicio',
        'texto_auxiliar',
        'imagem_enunciado',
        'enunciado',
        'enunciado_questao_a',
        'enunciado_questao_b',
        'enunciado_questao_c',
        'enunciado_questao_d',
        'enunciado_questao_e',
        'resposta_questao',
        'numero_a',
        'numero_b',
        'operacao',
        'numero_minimo',
        'numero_maximo'

    ];

}
