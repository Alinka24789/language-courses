<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->bigInteger('course_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('units', function (Blueprint $table) {

            $table->index(['course_id'], 'fk_units_courses_course_idx');

            $table->foreign('course_id', 'fk_units_courses_course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
