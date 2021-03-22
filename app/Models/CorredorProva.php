<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorredorProva extends Model
{
    use HasFactory;

    protected $table = "corredor_prova";
    
    protected $fillable = [
        "corredor_id",
        "prova_id",
    ];

    public static function rules()
    {
        return [
            'corredor_id' => 'required|integer|exists:corredor,id',
            'prova_id' => 'required|integer|exists:prova,id',
        ];
    }


    public function corredor()
    {
        return $this->belongsTo(\App\Models\Corredor::class, 'corredor_id');
    }


    public function prova()
    {
        return $this->belongsTo(\App\Models\Prova::class, 'prova_id');
    }
}
