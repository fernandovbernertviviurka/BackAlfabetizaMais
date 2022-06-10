<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaHasProva extends Model
{
    use HasFactory;

    protected $table = "turma_has_prova";

    public $timestamps = false;

    protected $fillable = [
        'status',

    ];
}
