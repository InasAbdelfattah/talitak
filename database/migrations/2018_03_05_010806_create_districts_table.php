<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->integer('created_by')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->timestamps();

            $table->foreign('created_by')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('city_id')
            ->references('id')->on('cities')
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
        Schema::dropIfExists('districts');
    }
}
