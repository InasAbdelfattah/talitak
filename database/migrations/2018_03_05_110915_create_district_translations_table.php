<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->integer('district_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['district_id', 'locale']);
            $table->timestamps();

            // $table->foreign('district_id')
            // ->references('id')->on('districts')
            // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('district_translations');
    }
}
