<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            # "type":"zorgverlening","sector":"","name":"Az Klina \/ daghospitaal",
            # "type_requested":"mondmasker_hulp","number_requested":"50",
            # "comments":"",
            #"phone":"","cellphone":"","email":"Natasha.deheel@hotmail.com","other_contact":"","tav":"Natasha De Heel"
            #,"street":"Augustijnslei","number":"100","zip":"2930","city":"Brasschaat","done":"1","confirmed":"1","country":"","latitude":null,"longitude":null},
            $table->string('identifier');
            $table->integer('customer_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('helper_id')->unsigned()->nullable();
            $table->tinyInteger('status_id')->unsigned()->default(0);
            $table->timestamps();
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
