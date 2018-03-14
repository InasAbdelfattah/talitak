<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->longText('description');
            $table->enum('gender_type', ['male','female','both']);
            $table->enum('provider_type', ['male','female']);
            $table->enum('service_place', ['center','home']);
            $table->integer('serviceType_id')->unsigned();
            $table->integer('provider_id')->unsigned();
            $table->integer('center_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->string('price',255);
            $table->string('photo',255);
            $table->unsignedBigInteger('seen_count');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('serviceType_id')
            ->references('id')->on('service_types')
            ->onDelete('cascade');

            $table->foreign('provider_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('center_id')
            ->references('id')->on('centers')
            ->onDelete('cascade');

            $table->foreign('district_id')
            ->references('id')->on('districts')
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
        Schema::dropIfExists('services');
    }
}
