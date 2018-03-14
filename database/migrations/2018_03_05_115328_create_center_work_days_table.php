<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCenterWorkDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('center_work_days', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day',100);
            $table->time('from');
            $table->time('to');
            $table->integer('center_id')->unsigned();
            $table->timestamps();

            $table->foreign('center_id')
            ->references('id')->on('centers')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('center_work_days');
    }
}
