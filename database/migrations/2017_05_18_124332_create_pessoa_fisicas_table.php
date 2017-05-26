<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaFisicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa_fisicas', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('profissao_id')->nullable()->unsigned();
           $table->string('cpf')->nullable();
           $table->string('cnh')->nullable();
           $table->string('rg')->nullable();
           $table->string('nome');           
           $table->string('sobrenome')->nullable();           
           $table->string('apelido')->nullable();            
           $table->date('nascimento')->nullable();
           $table->integer('genero')->nullable();
           $table->string('cnh_categoria')->nullable();
           $table->integer('escolaridade')->nullable();
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
        Schema::dropIfExists('pessoa_fisicas'); 
    }
}
