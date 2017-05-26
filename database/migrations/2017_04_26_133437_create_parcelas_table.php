<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parcelas', function(Blueprint $table) {
            $table->increments('id');

						$table->integer('movimento_id')->unsigned();

						$table->string('status',50);

						$table->date('data_vencimento');
						$table->date('data_pagamento')->nullable();

						$table->decimal('valor_parcela',10,2);
						$table->decimal('valor_pago',10,2)->nullable();

						$table->integer('numero_parcela');

						$table->foreign('movimento_id')->references('id')->on('movimentos');

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
			Schema::table('parcelas', function (Blueprint $table){
        $table->dropForeign('parcelas_movimento_id_foreign');
      });

      Schema::dropIfExists('parcelas');
	}

}
