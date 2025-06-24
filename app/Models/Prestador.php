<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prestador extends Model
{
    use HasFactory;

    protected $table = 'prestadores';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'uf',
        'latitude',
        'longitude',
        'situacao',
    ];

    public function servicos()
    {
        return $this->belongsToMany(
            Servico::class,
            'servico_prestadores',
            'prestador_id',
            'servico_id'
        )->withPivot([
            'km_saida',
            'valor_saida',
            'valor_km_excedente'
        ]);
    }
}
