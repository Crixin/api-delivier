<?php

namespace App\Http\Controllers;

use App\Models\ResultadoProva;
use App\Models\CorredorProva;
use Illuminate\Http\Request;
use App\Services\ValidationService;

class ResultadoProvaController extends Controller
{
    public function index()
    {
        return ResultadoProva::all();
    }


    public function store(Request $request)
    {
        try {
            $validator = new ValidationService(ResultadoProva::rules(), $request->all());
            $errors = $validator->make();

            if ($errors) {
                throw new \Exception($errors->messages()->all());
            }

            $corredorProva = CorredorProva::where([
                ['corredor_id', '=', $request->corredor_id],
                ['prova_id', '=', $request->prova_id]
            ])->first();

            if (!$corredorProva) {
                throw new \Exception("O corredor não está cadastrado para essa prova.");
            }

            if (ResultadoProva::where([['corredor_prova_id', '=', $corredorProva->id]])->first()) {
                throw new \Exception("O corredor já possui um resultado para essa prova.");
            }

            $data = $request->all();
            $data['corredor_prova_id'] = $corredorProva->id;

            $resultadoProva = ResultadoProva::create($data);
            return response()->json(['data' => $resultadoProva]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    public function show($resultadoProva)
    {
        return ResultadoProva::findOrFail($resultadoProva);
    }


    public function update(Request $request, $resultadoProva)
    {
        $resultadoProva = ResultadoProva::findOrFail($resultadoProva);
        $resultadoProva->update($request->all());
    }


    public function destroy($resultadoProva)
    {
        $resultadoProva = ResultadoProva::findOrFail($resultadoProva);
        return $resultadoProva->delete();
    }
}
