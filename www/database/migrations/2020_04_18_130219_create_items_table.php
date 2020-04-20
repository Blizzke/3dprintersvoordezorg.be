<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->string('name')->unique();
            $table->decimal('price')->nullable();
            // Maximum price or actual price
            $table->tinyInteger('is_max')->default(1);
            // Price is without VAT?
            $table->tinyInteger('vat_ex')->default(0);
            // VAT percentage, if without
            $table->integer('vat')->default(21);
            // Filled with |<sector>|<sector>| to limit articles to specific sectors
            $table->string('sector')->nullable();
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
        Schema::dropIfExists('items');
    }
}
