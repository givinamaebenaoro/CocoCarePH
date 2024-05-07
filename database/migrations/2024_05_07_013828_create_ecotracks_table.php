<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcotracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('ecotracks', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('task_name');
        $table->text('task_description');
        $table->date('date');
        $table->text('tasks'); // Changed from json to text
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
        Schema::dropIfExists('ecotracks');
    }
}
