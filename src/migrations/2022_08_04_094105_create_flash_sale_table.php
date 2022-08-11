<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlashSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->binary('uuid', 16);
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('excerpt', 255)->nullable();
            $table->integer('discount_price')->default(0);
            $table->integer('discount_percent')->default(0);
            $table->integer('user_level')->default(0);
            $table->integer('is_publish')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('ended_at');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->index(['user_level', 'is_publish']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flash_sales');
    }
}
