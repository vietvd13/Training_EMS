<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuestionTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_question', function (Blueprint $table) {
           $table->bigInteger('question_id')->unsigned();
           $table->bigInteger('test_id')->unsigned();

            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('test_id')
                ->references('id')
                ->on('tests')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
