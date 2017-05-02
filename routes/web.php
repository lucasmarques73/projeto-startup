<?php

//Rotdas das Movimentações
Route::get('/movimentos', ['as' => 'movimentos.index', 'uses' => 'MovimentosController@index']);
Route::post('/movimentos',['as' => 'movimentos.salvar', 'uses' => 'MovimentosController@store'] );
Route::get('/movimentos/novo', ['as' => 'movimentos.novo', 'uses' => 'MovimentosController@create']);

Route::get('/movimentos/{movimento_id}/parcelas',['as' => 'movimentos.parcela', 'uses' => 'ParcelasController@show']);

// Rotas das Parcelas
Route::get('/parcelas', ['as' => 'parcelas.index' , 'uses' => 'ParcelasController@index']);
Route::post('/parcelas', ['as' => 'parcelas.salvar', 'uses' => 'ParcelasController@store']);
Route::put('/parcelas', ['as' => 'parcelas.salvar', 'uses' => 'ParcelasController@update']);
Route::get('/parcelas/novo', ['as' => 'parcelas.novo', 'uses' => 'ParcelasController@create']);
Route::get('/parcelas/{id}/editar', ['as' => 'parcelas.edit', 'uses' => 'ParcelasController@edit']);
Route::patch('/parcelas/{id}', ['as' => 'parcelas.edit', 'uses' => 'ParcelasController@update']);


//--------- Pagar parcela
Route::put('/parcelas/{id}/pagar', ['as' => 'parcelas.pagar', 'uses' => 'ParcelasController@registrarPagamento']);

//Parcelas PDF
Route::get('/parcelas/pdf', function(){
  $parcelas = App\Entities\Parcela::all();
  $pdf = PDF::loadView('parcelas.pdf.pdf',['parcelas' => $parcelas]);
  return $pdf->download('parcelas.pdf');
});
