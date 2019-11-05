<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositosCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depositos_cotizaciones', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('deposito_id')->unsigned();
            $table->integer('cotizacion_id')->unsigned();
            $table->float('monto_deposito_asignado');

            //RELACIONES
            $table->foreign('deposito_id')->references('id')->on('depositos');
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones');
            
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
        Schema::dropIfExists('depositos_cotizaciones');
    }
}
