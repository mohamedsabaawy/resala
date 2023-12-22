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
        Schema::create('check_types_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('users_id')->unsigned();
            $table->unsignedBiginteger('check_types_id')->unsigned();
            $table->tinyInteger('pass'); //0=> not pass 1=>pass
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_types_users');
    }
};
