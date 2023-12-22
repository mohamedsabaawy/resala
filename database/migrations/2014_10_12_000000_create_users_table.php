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
            $table->bigInteger('code')->unique()->nullable();
            $table->string('name');
            $table->string('phone',15)->nullable();
            $table->string('card_id',14)->nullable();
            $table->string('photo')->nullable();
            $table->string('password')->default(bcrypt(123456));
            $table->date('join_date');
            $table->longText('comment')->nullable();
            $table->bigInteger("branch_id");
            $table->bigInteger("team_id");
            $table->bigInteger("position_id");
            $table->enum('status',['active','hold','out'])->default('active');
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
