<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lessonId')->constrained('lessons');
            $table->foreignId('userId')->constrained('users');
            $table->string('lessonTitle');
            $table->string('lessonContent');
            $table->date('startDate');
            $table->date('endDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_works');
    }
};
