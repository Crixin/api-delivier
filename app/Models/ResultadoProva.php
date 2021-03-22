<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoProva extends Model
{
    use HasFactory;

    protected $table = "resultado_prova";
    
    protected $fillable = [
        "corredor_prova_id",
        "hora_inicio",
        "hora_fim",
    ];

    public static function rules()
    {
        return [
            'hora_inicio' => 'required|date_format:H:i:s',
            'hora_fim' => 'required|date_format:H:i:s|after:hora_inicio',
        ];
    }


    public function corredorProva()
    {
        return $this->belongsTo(\App\Models\CorredorProva::class, 'corredor_prova_id');
    }
}
