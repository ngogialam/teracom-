<?php

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
        Schema::create('step_group_condition', function (Blueprint $table) {
            $table->id();
            $table->foreign('group_first_step')->references('id')->on('process_step')->default(null)->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('group_first_step')->nullable()->index();
            $table->integer('step_condition')->comment('1: AND, 2: OR')->nullable()->default(1);
            $table->integer('step_order')->nullable()->default(0);
            $table->integer('created_at')->nullable();
            $table->integer('deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step_group_condition');
    }
};
