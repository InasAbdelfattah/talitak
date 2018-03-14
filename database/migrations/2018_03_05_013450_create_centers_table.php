<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->enum('place', ['home','center']);
            $table->string('lat');
            $table->string('lng');
            $table->string('address');
            $table->boolean('is_accepted');
            $table->boolean('status');
            $table->enum('type', ['person','center']);
            $table->string('document_photo');
            $table->integer('user_id')->unsigned();
            $table->integer('city_id')->unsigned();

            $table->timestamps();

            $table->foreign('user_id')
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
        Schema::dropIfExists('centers');
    }
}
