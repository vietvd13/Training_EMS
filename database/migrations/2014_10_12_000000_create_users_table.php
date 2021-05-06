<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('birthday')->nullable();
            $table->integer('education_level')->nullable();
            $table->integer('toeic_grade')->nullable();
            $table->string('exp_detail')->nullable();
            $table->integer('department')->nullable();
            $table->integer('ex_in_ternal')->nullable();
            $table->string('address')->nullable();
            $table->integer('major_programing')->nullable();
            $table->string('position')->nullable();
            $table->string('phone')->nullable();
            //major_programing 
            $table->rememberToken();
            $table->timestamps();
//             Thông tin của trainee: Tên, tài khoản, tuổi, ngày sinh, trình đọ học vấn, ngôn ngữ lập trình, điểm TOEIC, kinh nghiệm chi tiết, bộ phần làm việc, vị trí...
// Trainer: Tên, External or Internal type, sdt, email, địa chỉ...
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
