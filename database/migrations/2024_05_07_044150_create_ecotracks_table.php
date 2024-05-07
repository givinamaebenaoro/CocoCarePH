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
            $table->string('name')->nullable();
            $table->string('task_name')->nullable()->default('No task name provided');
            $table->text('task_description')->nullable();
            $table->date('date')->nullable()->default(now());
            $table->text('tasks')->nullable();
            $table->integer('answer_count')->nullable()->default(0);
            $table->date('last_answered_date')->nullable();
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
