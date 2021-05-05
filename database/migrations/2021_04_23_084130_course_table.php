<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // admin = full quyen
    // staff = tao course cho tranner, tao class cho trainee, tao account trainee
    // tranner =  tao question, tao bai test
    // traninee = tra loi question
    // => class => course => test => question
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id'); // auto increment
            $table->string('course_name'); // varchar
            $table->string('course_detail');
            $table->timestamp('failed_at')->useCurrent();
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
