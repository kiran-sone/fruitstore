<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fruits', function (Blueprint $table) {
            $table->increments('fruit_id');
            $table->string('name')->index('indexfruitname');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 0);
            $table->integer('stock_quantity')->nullable();
            $table->unsignedInteger('type_id');

            $table->foreign('type_id')->references('type_id')->on('fruits_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fruits');
    }
}
