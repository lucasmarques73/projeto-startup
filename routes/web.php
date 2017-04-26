<?php

//Rotdas das Movimentações
Route::get('/movimentos', ['as' => 'movimentos.index', 'uses' => 'MovimentosController@index']);
Route::post('/movimentos',['as' => 'movimentos.salvar', 'uses' => 'MovimentosController@store'] );
Route::get('/movimentos/novo', ['as' => 'movimentos.novo', 'uses' => 'MovimentosController@create']);

// Rotas das Parcelas
Route::get('/parcelas', ['as' => 'parcelas.index' , 'uses' => 'ParcelasController@index']);
Route::post('/parcelas', ['as' => 'parcelas.salvar', 'uses' => 'ParcelasController@store']);
Route::get('/parcelas/novo', ['as' => 'parcelas.novo', 'uses' => 'ParcelasController@create']);
