<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code')->unique()->nullable();//
            $table->string('name');//
            $table->string('address')->nullable();////
            $table->string('email')->nullable();/////
            $table->enum('gender',['male','female']);/////
            $table->string('phone',15)->nullable();//
            $table->string('photo')->nullable();
            $table->string('password')->default(bcrypt(123456));
            $table->date('join_date')->nullable();
            $table->date('birth_date')->nullable();/////
            $table->longText('comment')->nullable();
            $table->string('national_id',14)->nullable();//الرقم القومي//
            $table->tinyInteger("marital_status_id")->nullable();//الحالة الجتماعية//
            $table->smallInteger("qualification_id")->nullable();//المؤهل//
            $table->Integer("nationality_id")->nullable();//الجنسية//
            $table->bigInteger("branch_id")->nullable();//الفرع//
            $table->TinyInteger("job_id")->nullable();//النشاط//
            $table->bigInteger("team_id")->nullable();//اللجنة//
            $table->bigInteger("position_id")->nullable();//الصفة//
            $table->TinyInteger("degree_id")->nullable();//درجة التطوع//
            $table->TinyInteger('status_id')->nullable();//حالة التطوع//
            $table->TinyInteger("category_id")->nullable();//التصنيف داخل المتابعة او خارج المتابعة//
            $table->enum('role',['admin','supervisor','user'])->default('user');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
