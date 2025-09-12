<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteOutraConexao extends Model
{
    
    protected $connection = 'outra_conexao'; // Nome da conexão definida em config/database.php
    protected $table = 'clientes';
    protected $primaryKey = 'idClientes'; // chave primária correta

    public $timestamps = false; // essa tabela não parece ter `created_at` e `updated_at`

    protected $fillable = [
        'empresa_id', 'nomeCliente', 'nomeFantazia', 'documento',
        'telefone', 'celular', 'email', 'rua', 'numero', 'bairro',
        'cidade', 'estado', 'cep', 'complemento'
    ];
}
