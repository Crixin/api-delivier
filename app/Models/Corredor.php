<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corredor extends Model
{
    use HasFactory;

    protected $table = "corredor";
    
    protected $fillable = [
        "nome",
        "cpf",
        "data_nascimento",
    ];

    public static function rules()
    {
        return [
            'cpf' => 'required|cpf',
            'nome' => 'required|string',
            'data_nascimento' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d')
        ];
    }
}
