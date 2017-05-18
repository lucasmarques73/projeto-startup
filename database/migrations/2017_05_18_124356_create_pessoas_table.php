<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
           $table->increments('id');
            $table->string('end_cep');
            $table->string('end_logradouro');
            $table->string('end_complemento');
            $table->string('end_bairro');
            $table->string('end_cidade');
            $table->string('end_uf');
            $table->string('end_numero');
            $table->string('tel_preferencial');
            $table->string('tel_alternativo');
            $table->string('email');
            $table->string('email_alternativo');
            $table->integer('pref_email');
            $table->integer('pref_sms');
            $table->integer('pref_boleto');
            $table->string('Matricula');
            $table->string('Id_Externo');
           
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
        Schema::dropIfExists('pessoas');
    }
}
