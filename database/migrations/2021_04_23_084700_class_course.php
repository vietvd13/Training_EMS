<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_course', function (Blueprint $table) {
            $table->bigInteger('class_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->primary(['class_id','course_id']);
            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
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
