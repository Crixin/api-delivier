<?php

namespace App\Http\Controllers;

use App\Models\Prova;
use Illuminate\Http\Request;
use App\Services\ValidationService;

class ProvaController extends Controller
{
    public function index()
    {
        return Prova::all();
    }


    public function store(Request $request)
    {
        $validator = new ValidationService(Prova::rules(), $request->all());
        $errors = $validator->make();

        if ($errors) {
            return response()->json(['message' => $errors->messages()->all()], 500);
        }
        
        $prova = Prova::create($request->all());
        return response()->json(['data' => $prova]);
    }


    public function show($prova)
    {
        return Prova::findOrFail($prova);
    }


    public function update(Request $request, $prova)
    {
        $prova = Prova::findOrFail($prova);
        $prova->update($request->all());
    }


    public function destroy($prova)
    {
        $prova = Prova::findOrFail($prova);
        return $prova->delete();
    }
}
