<?php

//Rotdas das Movimentações
Route::get('/movimentacoes', ['as' => 'movimentacao.index', 'uses' => 'MovimentosController@index']);
Route::post('/movimentacoes',['as' => 'movimentacao.salvar', 'uses' => 'MovimentosController@store'] );
Route::get('/movimentacoes/novo', function () { return view('movimentos.form-movimentacao'); });

// Rotas das Parcelas
Route::get('/parcelas', ['as' => 'parcelas.index' , 'uses' => 'ParcelasController@index']);
Route::post('/parcelas', ['as' => 'parcelas.salvar', 'uses' => 'ParcelasController@store']);
Route::get('/parcelas/novo', ['as' => 'parcelas.novo', 'uses' => 'ParcelasController@create']);
