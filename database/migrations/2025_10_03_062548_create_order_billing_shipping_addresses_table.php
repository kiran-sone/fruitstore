<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBillingShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_billing_shipping_addresses', function (Blueprint $table) {
            $table->id('oa_id'); // Primary key
            $table->unsignedBigInteger('oid');
            $table->foreign('oid')
                ->references('order_id')
                ->on('orders')
                ->cascadeOnDelete();
            $table->string('b_fullname');
            $table->string('b_phone');
            $table->string('b_email')->nullable();
            $table->string('b_address');
            $table->string('b_pincode');
            $table->string('s_fullname');
            $table->string('s_phone');
            $table->string('s_email')->nullable();
            $table->string('s_address');
            $table->string('s_pincode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_billing_shipping_addresses');
    }
}
