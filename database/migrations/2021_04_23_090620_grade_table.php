<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trainee_id')->unsigned();
            $table->bigInteger("test_id")->unsigned();
            $table->bigInteger('class_id')->unsigned();
            $table->integer('grade');

            $table->foreign('trainee_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('test_id')
                ->references('id')
                ->on('tests')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('restrict')->onUpdate('restrict');
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
