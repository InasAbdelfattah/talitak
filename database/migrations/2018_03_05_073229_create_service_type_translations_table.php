<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->integer('service_type_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['service_type_id', 'locale']);
            $table->timestamps();

            // $table->foreign('service_type_id')
            // ->references('id')->on('service_types')
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
        Schema::dropIfExists('service_type_translations');
    }
}
