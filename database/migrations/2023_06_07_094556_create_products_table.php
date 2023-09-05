<?php

use App\Enums\Product\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->double('price');
            $table->double('price_selling')->nullable();
            $table->double('price_promotion')->nullable();
            $table->char('sku', 50)->nullable();
            $table->boolean('manager_stock')->default(false);
            $table->integer('qty')->default(0);
            $table->boolean('in_stock')->default(true);
            $table->tinyInteger('status')->default(ProductStatus::Published->value);
            $table->text('feature_image')->nullable();
            $table->text('gallery')->nullable();
            $table->integer('viewed')->default(0);
            $table->longText('title_seo')->nullable();
            $table->text('desc_seo')->nullable();
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
        Schema::dropIfExists('products');
    }
};
