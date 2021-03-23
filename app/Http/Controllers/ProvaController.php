<?php

namespace App\Http\Controllers;

use App\Models\Prova;
use Illuminate\Http\Request;
use App\Services\ValidationService;

class ProvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Prova::orderBy('id')->get();
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
            $validator = new ValidationService(Prova::rules(), $request->all());
            $errors = $validator->make();

            if ($errors) {
                throw new \Exception($errors->messages()->all());
            }
            
            $prova = Prova::create($request->all());
            
            return response()->json(['data' => $prova]);
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
    public function show($prova)
    {
        try {
            return response()->json(['data' => Prova::findOrFail($prova)]);
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
    public function update(Request $request, $prova)
    {
        try {
            $prova = Prova::findOrFail($prova);
            $data = $request->all();
            unset($data['data']);
            $prova->update($data);

            return response()->json(['data' => $prova]);
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
    public function destroy($prova)
    {
        try {
            $prova = Prova::findOrFail($prova);
            $prova->delete();

            return response()->json(['data' => $prova]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
