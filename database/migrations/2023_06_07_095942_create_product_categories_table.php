<?php

use App\Enums\ProductCategory\ProductCategoryStatus;
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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('_lft');
            $table->integer('_rgt');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('feature_image')->nullable();
            $table->integer('position')->default(0);
            $table->tinyInteger('status')->default(ProductCategoryStatus::Published->value);
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('product_categories')->onDelete('SET NULL'); 
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
