<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 150)->unique();
            $table->longText('product_short_description');
            $table->longText('product_long_description');
            $table->float('product_price');
            $table->integer('product_quantity');
            $table->integer('alert_quantity');
            $table->string('product_thumbnail_photo')->default('default.png');
            $table->integer('product_category_id');
            $table->longText('slug');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
