<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;
    protected $table = "aluno";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'usuario',
        'senha',
        'idade',
        'nome_completo_responsavel',
        'email_responsavel',
    ];

    public function aluno(){
        return $this->hasOne(Turma::class, 'id');
    }
}
