<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id'); // Primary key
            $table->foreignId('uid')->constrained('users')->cascadeOnDelete();
            $table->dateTime('order_date');

            // Extra useful columns
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('pay_method', 20)->default('pending'); // e.g. 'UPI', 'Credit Card', 'PayPal', 'CoD'
            $table->string('pay_status', 20)->default('pending'); // e.g. pending, paid, shipped
            $table->string('order_status', 20)->default('pending'); // e.g. 'Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'
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
        Schema::dropIfExists('orders');
    }
}
