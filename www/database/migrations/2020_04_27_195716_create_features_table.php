<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('value');
            $table->string('name')->nullable();
            // If a user can add/remove this feature himself/show it in the frontend
            $table->tinyInteger('modifiable')->default(0);

            // Again that key too long error and can't fix it with Schema/Builder::defaultStringLength so f* it.
            // $table->unique(['type', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}
