<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('recipient_name');
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

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_addresses');
    }
}
