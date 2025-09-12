<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartaCorrecao;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Tools;
use NFePHP\NFe\Common\Standardize;
use Exception;
use Illuminate\Support\Facades\Log;

class CartaCorrecaoController extends Controller
{
    /**
     * Exibe o formul���rio para envio da Carta de Corre������o
     */
    public function form()
    {
        return view('carta-correcao.form');
    }

    /**
     * Emite a Carta de Corre������o Eletr���nica (CC-e)
     */
    public function emitir(Request $request)
    {
        $request->validate([
            'chave' => 'required|string|size:44',
            'texto' => 'required|string|max:1000'
        ]);

        try {
            // Configura������o e Certificado
            $configJson = file_get_contents(config_path('nfe.json'));
            $certificadoPath = storage_path('certs/' . env('CERTIFICADO_ARQUIVO', 'seucertificado.pfx'));
            $senha = env('CERTIFICADO_SENHA', 'senha_padrao');

            $certificado = file_get_contents($certificadoPath);
            $certificate = Certificate::readPfx($certificado, $senha);
            $tools = new Tools($configJson, $certificate);
            $tools->model('55'); // NF-e modelo 55

            // Dados da carta
            $chave = $request->input('chave');
            $texto = $request->input('texto');

            // Envio da CC-e
            $resp = $tools->sefazCCe($chave, $texto);

            $standard = new Standardize();
            $std = $standard->toStd($resp);

            // Verifica retorno da SEFAZ
            if ($std->cStat != 128 || $std->infEvento->cStat != 135) {
                return back()->withErrors(['Erro ao emitir carta: ' . $std->infEvento->xMotivo]);
            }

            // Cria diret���rio se n���o existir
            $xmlDir = storage_path('app/xmls/cce/');
            if (!is_dir($xmlDir)) {
                mkdir($xmlDir, 0755, true);
            }

            // Salva o XML
            $xmlFileName = $chave . '-' . now()->timestamp . '-cce.xml';
            $xmlPath = 'xmls/cce/' . $xmlFileName;
            file_put_contents(storage_path('app/' . $xmlPath), $resp);

            // Salva no banco de dados
            CartaCorrecao::create([
                'chave'     => $chave,
                'texto'     => $texto,
                'protocolo' => $std->infEvento->nProt,
                'cStat'     => $std->infEvento->cStat,
                'xMotivo'   => $std->infEvento->xMotivo,
                'xml_path'  => $xmlPath,
            ]);

            return back()->with('success', 'Carta enviada com sucesso! Protocolo: ' . $std->infEvento->nProt);
        } catch (Exception $e) {
            Log::error('Erro ao emitir CC-e: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withErrors(['Erro: ' . $e->getMessage()]);
        }
    }

    /**
     * Lista todas as cartas de corre������o emitidas
     */
    public function listar()
    {
        $cartas = CartaCorrecao::latest()->paginate(15);
        return view('carta-correcao.listar', compact('cartas'));
    }

    /**
     * Permite baixar o XML de uma carta de corre������o
     */
    public function download($id)
    {
        $carta = CartaCorrecao::findOrFail($id);
        $file = storage_path('app/' . $carta->xml_path);

        if (!file_exists($file)) {
            abort(404, 'Arquivo XML n���o encontrado.');
        }

        return response()->download($file, basename($file));
    }
}
