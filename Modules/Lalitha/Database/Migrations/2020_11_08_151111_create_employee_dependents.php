<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDependents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('suburb')->nullable();
            $table->string('city');
            $table->string('zipcode');
            $table->string('country');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->softDeletes('deleted_at', 0);
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cellphone');
            $table->string('home')->nullable();
            $table->string('telephone')->nullable();
            $table->string('work')->nullable();
            $table->string('other')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->softDeletes('deleted_at', 0);
            $table->foreign('employee_id')->references('id')->on('employees');
        });

        Schema::create('next_of_kin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('cellphone');
            $table->string('other_phone')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->softDeletes('deleted_at', 0);
            $table->foreign('employee_id')->references('id')->on('employees');
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('begin')->nullable();
            $table->date('end')->nullable();
            $table->boolean('is_signed')->default(false)->nullable();
            $table->boolean('is_permanent')->default(false)->nullable();
            $table->boolean('is_active')->default(false)->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->softDeletes('deleted_at', 0);
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('next_of_kin');
    }
}
