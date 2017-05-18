<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaJuridicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa_juridicas', function (Blueprint $table) {
           $table->increments('id');
           $table->string('cnpj');
           $table->string('razao_social')->nullable();
           $table->string('nome_fantasia')->nullable();
           $table->integer('responsavel_id')->nullable()->unsigned();
           $table->integer('contabilidade_id')->nullable()->unsigned();
           $table->string('Matricula')->nullable();
           $table->string('Id_Externo')->nullable();
           $table->string('Situacao')->nullable();
           $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoa_juridicas');    
    }
}
