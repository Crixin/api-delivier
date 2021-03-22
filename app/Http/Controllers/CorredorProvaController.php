<?php

namespace App\Http\Controllers;

use App\Models\{CorredorProva, Prova};
use Illuminate\Http\Request;
use App\Services\ValidationService;

class CorredorProvaController extends Controller
{
    public function index()
    {
        return CorredorProva::all();
    }


    public function store(Request $request)
    {
        try {
            $validator = new ValidationService(CorredorProva::rules(), $request->all());
            $errors = $validator->make();

            if ($errors) {
                throw new \Exception($errors->messages()->all());
            }

            $provasCadastradasCorredor = CorredorProva::where([
                ["corredor_id", "=", $request->corredor_id],
            ])->pluck('prova_id')->toArray();
            
            $provaNova = Prova::findOrFail($request->prova_id);

            $datasProvasParticipantes = Prova::whereIn("id", $provasCadastradasCorredor)->pluck('data')->toArray();
            
            if (in_array($provaNova->data, $datasProvasParticipantes)) {
                throw new \Exception("O corredor não pode ter duas corridas no mesmo dia.");
            }
            
            $corredorProva = CorredorProva::create($request->all());
            return response()->json(['data' => $corredorProva]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    public function show($corredorProva)
    {
        return CorredorProva::findOrFail($corredorProva);
    }


    public function update(Request $request, $corredorProva)
    {
        $corredorProva = CorredorProva::findOrFail($corredorProva);
        $corredorProva->update($request->all());
    }


    public function destroy($corredorProva)
    {
        $corredorProva = CorredorProva::findOrFail($corredorProva);
        return $corredorProva->delete();
    }
}
