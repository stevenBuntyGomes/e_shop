<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('slider_header', 150)->unique();
            $table->longText('slider_description');
            $table->string('slider_button', 150);
            $table->string('slider_link', 190);
            $table->string('slider_image', 190)->default('default.png');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    // slider_header
    //
    //
    //
    // slider_image
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
