<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    use HasFactory;

    protected $table = "prova";
    
    protected $fillable = [
        "tipo_prova",
        "data",
    ];

    public static function rules()
    {
        return [
            'tipo_prova' => 'required|integer|in:3,5,10,21,42',
            'data' => 'required|date'
        ];
    }
}
