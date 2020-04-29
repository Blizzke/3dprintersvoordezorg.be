<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelperFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helper_features', function (Blueprint $table) {
            $table->id();

            $table->integer('helper_id')->unsigned()->index();
            // $table->foreign('helper_id')->references('id')->on('helpers')->onDelete('cascade');

            $table->integer('feature_id')->unsigned()->index();
            //$table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');

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
        Schema::dropIfExists('helper_features');
    }
}
