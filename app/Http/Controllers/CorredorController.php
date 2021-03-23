<?php

namespace App\Http\Controllers;

use App\Models\Corredor;
use Illuminate\Http\Request;
use App\Services\ValidationService;

class CorredorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Corredor::orderBy('id')->get();
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
            $validator = new ValidationService(Corredor::rules(), $request->all());
            $errors = $validator->make();

            if ($errors) {
                throw new \Exception($errors->messages()->all());
            }
            
            $corredor = Corredor::create($request->all());
            
            return response()->json(['data' => $corredor]);
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
    public function show($corredor)
    {
        try {
            return response()->json(['data' => Corredor::findOrFail($corredor)]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $corredor)
    {
        try {
            $corredor = Corredor::findOrFail($corredor);
            $corredor->update($request->all());

            return response()->json(['data' => $corredor]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($corredor)
    {
        try {
            $corredor = Corredor::findOrFail($corredor);
            $corredor->delete();

            return response()->json(['data' => $corredor]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
