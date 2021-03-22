<?php

Route::apiResource('corredor', 'CorredorController');

Route::apiResource('prova', 'ProvaController');

Route::apiResource('corredor-prova', 'CorredorProvaController');

Route::apiResource('resultado-prova', 'ResultadoProvaController');

Route::get('classificacao/{tipoListagem}', 'ClassificacaoController@show');
