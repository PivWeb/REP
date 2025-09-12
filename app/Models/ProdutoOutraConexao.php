<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoOutraConexao extends Model
{
    protected $connection = 'outra_conexao'; // Nome da conexão definida em config/database.php
    protected $table = 'produtos'; // Nome da tabela de produtos
    protected $primaryKey = 'idProdutos'; // Ajuste conforme o nome da chave primária

    public $timestamps = false; // Se a tabela não usa created_at/updated_at

    protected $fillable = [
        'remessa_id', 'produto_id', 'quantidade', 'valor_unitario', 'sub_total',
        'cst_csosn', 'cst_pis', 'cst_cofins', 'cst_ipi', 'perc_icms', 'perc_pis',
        'perc_cofins', 'perc_ipi', 'pRedBC', 'vbc_icms', 'vbc_pis', 'vbc_cofins',
        'vbc_ipi', 'vBCSTRet', 'vFrete', 'modBCST', 'vBCST', 'pICMSST', 'vICMSST',
        'pMVAST', 'x_pedido', 'num_item_pedido', 'cest', 'valor_icms', 'valor_pis', 
        'valor_cofins', 'valor_ipi', 'cfop'
    ];
    
    
    /*protected $fillable = [
        'nomeProduto', 'codigo', 'ncm', 'cest', 'unidade',
        'preco', 'quantidade_estoque', 'descricao', 'categoria_id',
        'empresa_id', 'ativo'
    ];*/
}
