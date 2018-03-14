<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppRatiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_ratios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->string('service_charge',255);
            $table->string('app_ratio',255);
            $table->string('app_ratio_photo',255);
            $table->boolean('is_paid')->default(0);
            $table->boolean('is_paid_confirmed')->default(0);
            $table->string('money_photo',255);
            $table->timestamps();

            $table->foreign('provider_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('service_id')
            ->references('id')->on('services')
            ->onDelete('cascade');

            $table->foreign('order_id')
            ->references('id')->on('orders')
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
        Schema::dropIfExists('app_ratios');
    }
}
