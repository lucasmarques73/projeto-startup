<?php
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
//Rotdas das Movimentações
    Route::get('/movimentos', ['as' => 'movimentos.index', 'uses' => 'MovimentosController@index']);
    Route::post('/movimentos',['as' => 'movimentos.salvar', 'uses' => 'MovimentosController@store'] );
    Route::get('/movimentos/novo', ['as' => 'movimentos.novo', 'uses' => 'MovimentosController@create']);

    Route::get('/movimentos/{movimento_id}/parcelas',['as' => 'movimentos.parcela', 'uses' => 'ParcelasController@show']);

    //Parcelas PDF
    Route::get('/parcelas/report', ['as' => 'parcelas.report' , 'uses' => 'ParcelasController@report']);
    Route::get('/movimentos/report/{id}', ['as' => 'movimentos.reportParcela' , 'uses' => 'ParcelasController@reportParcela']);

    // Rotas das Parcelas
    Route::get('/parcelas', ['as' => 'parcelas.index' , 'uses' => 'ParcelasController@index']);
    Route::post('/parcelas', ['as' => 'parcelas.salvar', 'uses' => 'ParcelasController@store']);
    Route::put('/parcelas', ['as' => 'parcelas.salvar', 'uses' => 'ParcelasController@update']);
    Route::get('/parcelas/novo', ['as' => 'parcelas.novo', 'uses' => 'ParcelasController@create']);
    Route::get('/parcelas/{id}', ['as' => 'parcelas.edit', 'uses' => 'ParcelasController@edit']);
    Route::patch('/parcelas/{id}', ['as' => 'parcelas.edit', 'uses' => 'ParcelasController@update']);


    //--------- Pagar parcela
    Route::put('/parcelas/{id}/pagar', ['as' => 'parcelas.pagar', 'uses' => 'ParcelasController@registrarPagamento']);



    Route::get('/home', 'HomeController@index');
});
