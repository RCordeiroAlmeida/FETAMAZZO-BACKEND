<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProccessController extends Controller
{
    public function search($id){
        $url = "https://processos.prefeitura.sp.gov.br/Forms/consultarProcessos.aspx/CarregaDadosPorNumero";

        // remove não números
        $id = preg_replace('/\D/', '', $id);

        // aplica máscara
        $id =
            substr($id, 0, 4) . '.' .
            substr($id, 4, 4) . '/' .
            substr($id, 8, 7) . '-' .
            substr($id, 15, 1);

        $response = Http::withHeaders([
            "Content-Type" => "application/json; charset=utf-8",
            "Accept" => "application/json, text/javascript, */*; q=0.01",
            "X-Requested-With" => "XMLHttpRequest",
            "Referer" => "https://processos.prefeitura.sp.gov.br/Forms/consultarProcessos.aspx",
            "User-Agent" => "Mozilla/5.0"
        ])->post($url, [
            "pstrNumProcesso" => $id
        ]);

        $data = $response->json();

        // Se não tiver o campo d retorna o que veio
        if (!isset($data['d'])) {
            return response()->json([
                'status' => $response->status(),
                'raw_response' => $data
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        // Se "d" for string JSON → decodifica
        $conteudo = $data['d'];
        if (is_string($conteudo)) {
            $conteudo = json_decode($conteudo, true);
        }

        return response()->json(
            $conteudo,
            200,
            [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

}
