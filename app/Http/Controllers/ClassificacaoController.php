<?php

namespace App\Http\Controllers;

use App\Models\{CorredorProva, Prova, ResultadoProva};
use Illuminate\Http\Request;
use App\Services\ValidationService;
use Carbon\Carbon;

class ClassificacaoController extends Controller
{
    public function show($tipoListagem)
    {
        try {
            switch ($tipoListagem) {
                case 'tipo':
                    return $this->classificaoPorTipo();
                    break;
                case 'idade':
                    return $this->classificaoPorIdade();
                    break;
                default:
                    throw new \Exception("Tipo de ordenação inválida. Tente 'tipo' ou 'idade'");
                    break;
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    private function classificaoPorIdade()
    {
        $classPorTipo = $this->classificaoPorTipo();
        $results = [];

        foreach ($classPorTipo as $tipoProva => $listaProva) {
            foreach ($listaProva as $key => $infoResultado) {
                $idade = $infoResultado['idade'];
                switch ($idade) {
                    case ($idade <= 25):
                        $results[$tipoProva]["18-25"][] = $infoResultado;
                        break;
                    case ($idade <= 35):
                        $results[$tipoProva]["25-35"][] = $infoResultado;
                        break;
                    case ($idade <= 45):
                        $results[$tipoProva]["35-45"][] = $infoResultado;
                        break;
                    case ($idade <= 55):
                        $results[$tipoProva]["45-55"][] = $infoResultado;
                        break;
                    default:
                        $results[$tipoProva]["55+"][] = $infoResultado;
                    break;
                }
            }
        }
        
        //ORDENANDO E CLASSIFICANDO
        ksort($results);
        foreach ($results as $tipoProva => $listaIdade) {
            foreach ($listaIdade as $idade => $listaResultados) {
                $this->ordenaTempoProva($results[$tipoProva][$idade]);
                foreach ($listaResultados as $key => $info) {
                    $results[$tipoProva][$idade][$key]['classificacao'] = $key + 1 . "°";
                }
            }
        }
        return $results;
    }


    private function classificaoPorTipo()
    {
        $results = [];
        $resultadosProva = ResultadoProva::all();
        
        foreach ($resultadosProva as $key => $resultadoProva) {
            $corredor = $resultadoProva->corredorProva->corredor;

            $prova = $resultadoProva->corredorProva->prova;

            $start = Carbon::parse($resultadoProva->hora_inicio);
            $end = Carbon::parse($resultadoProva->hora_fim);
            
            $tempoProvaSecons = $start->diffInSeconds($end);
            $tempoProvaSecons = gmdate('H:i:s', $tempoProvaSecons);

            $results[$prova->tipo_prova][] = [
                "prova_id" => $prova->id,
                "tipo_prova" => $prova->tipo_prova,
                "corredor_id" => $corredor->id,
                "idade" => Carbon::parse($corredor->data_nascimento)->age,
                "nome" => $corredor->nome,
                'tempo_prova' => $tempoProvaSecons
            ];
        }

        //ORDENANDO
        ksort($results);
        foreach ($results as $key => $result) {
            $this->ordenaTempoProva($results[$key]);
        }

        //CLASSIFICANDO
        foreach ($results as $key => $result) {
            foreach ($result as $key2 => $info) {
                $results[$key][$key2]['classificacao'] = $key2 + 1 . "°";
            }
        }
        
        return $results;
    }


    private function ordenaTempoProva(&$array)
    {
        usort($array, function ($a, $b) {
            $a = $a['tempo_prova'];
            $b = $b['tempo_prova'];
        
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
    }
}
