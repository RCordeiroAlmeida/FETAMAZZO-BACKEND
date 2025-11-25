<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProccessController extends Controller
{
    public function search($id)
    {
        $url = "https://processos.prefeitura.sp.gov.br/Forms/consultarProcessos.aspx/CarregaDadosPorid";



        $id = preg_replace('/\D/', '', $id);
        $id =
            substr($id, 0, 4) . '.' .
            substr($id, 4, 4) . '/' .
            substr($id, 8, 7) . '-' .
            substr($id, 15, 1);


        $response = Http::withHeaders([
            "Content-Type" => "application/json",
        ])->post($url, [
            "pstrNumProcesso" => $id
        ]);

        return response($response->body());
    }
}
