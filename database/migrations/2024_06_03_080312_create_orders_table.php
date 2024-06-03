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
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->float('sub_total');
            $table->foreignId('shipping_id')->constrained('shippings')->onDelete('set null');
            $table->float('coupon')->nullable();
            $table->float('total_amount');
            $table->integer('quantity');
            $table->enum('payment_method', ['cod', 'paypal', 'cardpay'])->default('cod'); // Added 'cardpay' option if needed
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('status', ['new', 'process', 'delivered', 'cancel'])->default('new');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('shipping_id')->references('id')->on('shipping_addresses')->onDelete('SET NULL'); // Corrected foreign key reference
            $table->string('recipient_name'); // Removed nullable() for required fields
            $table->string('phone_number');
            $table->string('country');
            $table->string('region');
            $table->string('city');
            $table->string('barangay');
            $table->string('street_building');
            $table->string('unit_floor');
            $table->string('additional_info')->nullable();
            $table->enum('address_category', ['home', 'office']);
            $table->boolean('default_shipping')->default(false);
            $table->boolean('default_billing')->default(false);
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
