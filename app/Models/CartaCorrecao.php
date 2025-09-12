<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartaCorrecao extends Model
{
    protected $table = 'cartas_correcao'; // <- nome correto da tabela

    protected $fillable = [
        'chave',
        'texto',
        'protocolo',
        'cStat',
        'xMotivo',
        'xml_path',
    ];
}
