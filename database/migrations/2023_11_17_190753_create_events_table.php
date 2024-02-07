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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->longText('details');
            $table->string('photo')->nullable();
            $table->boolean('type')->default(0)->nullable();//0 =>event with date 1 => event without date
            $table->boolean('active')->default(1)->nullable();//0 =>event not active 1 => event active
            $table->bigInteger('team_id')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
