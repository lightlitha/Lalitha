<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->unique();
            $table->string('name')->unique();
            $table->decimal('price', 8, 2);
            $table->decimal('cost', 8, 2)->nullable();
            $table->time('duration');
            $table->time('delay_time')->nullable();
            $table->string('tag')->nullable();
            $table->boolean('is_active')->default(false)->nullable();
            $table->text('description')->nullable();
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('store_services');
    }
}
