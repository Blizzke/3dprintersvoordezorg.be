<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->unsigned();
            // Update type (comment, production, ...)
            $table->string('type');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('helper_id')->unsigned()->nullable();
            $table->integer('quantity')->nullable();
            $table->longText('comment')->nullable();
            $table->tinyInteger('status_id')->nullable();
            $table->tinyInteger('is_internal')->default(0);
            $table->timestamps();

            $table->index(['order_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_statuses');
    }
}
