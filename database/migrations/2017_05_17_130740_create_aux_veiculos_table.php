<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuxVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aux_veiculos', function (Blueprint $table) {
           $table->increments('id');
           $table->string('nome')->nullable();
           $table->string('placa')->nullable();
           $table->string('id_externo')->nullable();
           $table->string('id_externo_associado')->nullable();
           $table->string('cod_veiculo')->nullable();
           $table->string('matricula_associado')->nullable();
           $table->string('mes_final_carne')->nullable();
           $table->string('proprietario')->nullable();
           $table->string('classificacao_associado')->nullable();
           $table->string('estado_civil_associado')->nullable();
           $table->string('nome_mae')->nullable();
           $table->string('veiculo_vinculado')->nullable();
           $table->string('modelo')->nullable();
           $table->string('tipo_veiculo')->nullable();
           $table->string('cpf_cnpj')->nullable();
           $table->string('cpf_cnpj_proprietario')->nullable();
           $table->string('naturalidade')->nullable();
           $table->string('nome_pai')->nullable();
           $table->string('veiculo_agreagado')->nullable();
           $table->string('cavalo_veiculo')->nullable();
           $table->string('montadora')->nullable();
           $table->string('categoria')->nullable();
           $table->string('ano')->nullable();
           $table->string('cota')->nullable();
           $table->string('ano_mod')->nullable();
           $table->string('cor')->nullable();
           $table->string('chassi')->nullable();
           $table->string('valor_protegido')->nullable();
           $table->string('porcentagem_fipe_protegido')->nullable();
           $table->string('forma_pagamento_protecao')->nullable();
           $table->string('km')->nullable();
           $table->string('n_portas')->nullable();
           $table->string('alienacao')->nullable();
           $table->string('n_passageiros')->nullable();
           $table->string('cilindrada')->nullable();
           $table->string('tipo_pagamento_protecao')->nullable();
           $table->string('valor_fipe_veiculo')->nullable();
           $table->string('codigo_fipe')->nullable();
           $table->string('numero_motor')->nullable();
           $table->string('renavam')->nullable();
           $table->string('combustivel')->nullable();
           $table->timestamps();
       });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
