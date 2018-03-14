<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('gender', ['male','female']);
            $table->enum('place', ['home','center']);
            $table->date('order_date');
            $table->time('order_time');
            $table->longText('notes');
            $table->string('lat',255);
            $table->string('lng',255);
            $table->string('address',255);
            $table->string('price',100)->nullable();
            $table->boolean('discount_accept');
            $table->integer('user_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->boolean('user_is_finished')->default(0);
            $table->string('refuse_reasons',500)->nullable();

            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('service_id')
            ->references('id')->on('services')
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
        Schema::dropIfExists('orders');
    }
}
