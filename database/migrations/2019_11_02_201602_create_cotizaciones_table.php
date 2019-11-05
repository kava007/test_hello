<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('folio')->unique();
            $table->integer('cliente_id')->unsigned();
            $table->integer('auto_id')->unsigned();
            $table->float('precio');
            $table->date('fecha_creacion');

            //RELACIONES
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('auto_id')->references('id')->on('autos');


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
        Schema::dropIfExists('cotizaciones');
    }
}
