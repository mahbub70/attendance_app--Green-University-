<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id');
            $table->bigInteger('semester_id');
            $table->bigInteger('student_id');
            $table->bigInteger('subject_id');
            $table->integer('class_test_one')->nullable();
            $table->integer('class_test_two')->nullable();
            $table->integer('class_test_three')->nullable();
            $table->integer('class_test_avg')->nullable();
            $table->integer('assingment')->nullable();
            $table->integer('presentation')->nullable();
            $table->integer('attendance')->nullable();
            $table->integer('midterm')->nullable();
            $table->integer('final')->nullable();
            $table->integer('total')->nullable();
            $table->string('grade')->nullable();
            $table->string('added_by');
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
        Schema::dropIfExists('student_results');
    }
}
