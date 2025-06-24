<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'servicos';

    protected $fillable = [
        'nome',
        'valor_base',
        'descricao',
    ];

    public function prestadores()
    {
        return $this->belongsToMany(
            Prestador::class,
            'servico_prestadores',      // Nome da tabela pivot
            'servico_id',               // FK do serviço na pivot
            'prestador_id'              // FK do prestador na pivot
        );
    }
}
