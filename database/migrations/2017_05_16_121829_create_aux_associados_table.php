<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuxAssociadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aux_associados', function (Blueprint $table) {
           $table->increments('id');
           $table->string('Nome')->nullable();
           $table->string('Matricula')->nullable();
           $table->string('Contato')->nullable();
           $table->string('Id_Externo')->nullable();
           $table->string('CPF_CNPJ')->nullable();
           $table->string('Classificacao')->nullable();
           $table->string('CNH')->nullable();
           $table->string('RG')->nullable();
           $table->string('Data_Nascimento')->nullable();
           $table->string('Situacao')->nullable();
           $table->string('Data_Cadastro')->nullable();
           $table->string('Data_Exclusao')->nullable();
           $table->string('Data_Contrato')->nullable();
           $table->string('Categoria_CNH')->nullable();
           $table->string('Data_Vencimento')->nullable();
           $table->string('Sexo')->nullable();
           $table->string('Hora_de_Cadastro')->nullable();
           $table->string('Hora_Exclusao')->nullable();
           $table->string('Data_Final_Contrato')->nullable();
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
        Schema::dropIfExists('aux_associados');    
    }
}
