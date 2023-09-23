<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdAndCourseIdToCourseUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_user', function (Blueprint $table) {
            // Agregar las columnas user_id y course_id
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');

            // Definir las claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_user', function (Blueprint $table) {
            // Eliminar las claves foráneas y las columnas
            $table->dropForeign(['user_id']);
            $table->dropForeign(['course_id']);
            $table->dropColumn(['user_id', 'course_id']);
        });
    }
}
