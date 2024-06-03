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
            $table->unsignedBigInteger('user_id')->default(1);
            $table->text('tasks')->nullable();
            $table->integer('answer_count')->nullable()->default(0);
            $table->date('last_answered_date')->nullable();
            $table->integer('consecutive_days')->default(0); // Number of consecutive days completed
            $table->date('last_completed_date')->nullable(); // Last date a task was completed
            $table->enum('status',['new','complete','failed'])->default('new');
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
