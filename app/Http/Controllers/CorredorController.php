<?php

namespace App\Http\Controllers;

use App\Models\Corredor;
use Illuminate\Http\Request;
use App\Services\ValidationService;

class CorredorController extends Controller
{
    public function index()
    {
        return Corredor::all();
    }


    public function store(Request $request)
    {
        $validator = new ValidationService(Corredor::rules(), $request->all());
        $errors = $validator->make();

        if ($errors) {
            return response()->json(['message' => $errors->messages()->all()], 500);
        }
        
        $corredor = Corredor::create($request->all());
        return response()->json(['data' => $corredor]);
    }


    public function show($corredor)
    {
        return Corredor::findOrFail($corredor);
    }


    public function update(Request $request, $corredor)
    {
        $corredor = Corredor::findOrFail($corredor);
        $corredor->update($request->all());
    }


    public function destroy($corredor)
    {
        $corredor = Corredor::findOrFail($corredor);
        return $corredor->delete();
    }
}
