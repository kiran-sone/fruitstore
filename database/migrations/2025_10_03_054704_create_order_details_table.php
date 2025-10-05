<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('od_id'); // Primary key
            $table->unsignedBigInteger('oid');
            $table->foreign('oid')
                ->references('order_id')
                ->on('orders')
                ->cascadeOnDelete();
            $table->integer('fid');
            $table->foreign('fid')
                ->references('fruit_id')
                ->on('fruits')
                ->cascadeOnDelete();
            $table->integer('qty');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('sub_total', 10, 2);
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
        Schema::dropIfExists('order_details');
    }
}
