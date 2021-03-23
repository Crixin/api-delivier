<?php

namespace App\Http\Controllers;

use App\Models\ResultadoProva;
use App\Models\CorredorProva;
use Illuminate\Http\Request;
use App\Services\ValidationService;

class ResultadoProvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResultadoProva::orderBy('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($resultadoProva)
    {
        return ResultadoProva::findOrFail($resultadoProva);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($resultadoProva)
    {
        try {
            $resultadoProva = ResultadoProva::findOrFail($resultadoProva);
            $resultadoProva->delete();

            return response()->json(['data' => $resultadoProva]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
