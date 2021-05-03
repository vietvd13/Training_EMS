<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_teacher', function (Blueprint $table) {
            $table->bigInteger('class_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->primary(['class_id','teacher_id']);
            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
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
