<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuxAssociadosEndTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aux_associados_end', function (Blueprint $table) {
           $table->increments('id');
           $table->string('matricula')->nullable();
           $table->string('id_externo')->nullable();
           $table->string('placas_ativas')->nullable();
           $table->string('logradouro')->nullable();
           $table->string('bairro')->nullable();
           $table->string('cidade')->nullable();
           $table->string('email')->nullable();
           $table->string('regional')->nullable();
           $table->string('naturalidade')->nullable();
           $table->string('telefone')->nullable();
           $table->string('telefone_celular')->nullable();
           $table->string('id_radio')->nullable();
           $table->string('numero_radio')->nullable();
           $table->string('data_alteracao_situacao')->nullable();
           $table->string('cep')->nullable();
           $table->string('numero')->nullable();
           $table->string('complemento')->nullable();
           $table->string('email_auxiliar')->nullable();
           $table->string('uf')->nullable();
           $table->string('usuario')->nullable();
           $table->string('telefone_comercial')->nullable();
           $table->string('telefone_celular_auxiliar')->nullable();
           $table->string('id_radio_aux')->nullable();
           $table->string('telefone_fax')->nullable();
           $table->string('tipo_boleto_veiculo')->nullable();
           $table->string('mes_aniversario')->nullable();
           $table->string('observacoes')->nullable();
           $table->string('tipo_pessoa')->nullable();
           $table->string('numero_radio_aux')->nullable();
           $table->string('operadora')->nullable();
           $table->string('0')->nullable();
           $table->string('profissao')->nullable();
           $table->string('nome_do_pai')->nullable();
           $table->string('quantidade_veiculos')->nullable();
           $table->string('valor_produto_adicional')->nullable();
           $table->string('receber_e_mail')->nullable();
           $table->string('categoria')->nullable();
           $table->string('descricao_produto_adicional')->nullable();
           $table->timestamps();
       });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aux_associados_end');    
    }
}
