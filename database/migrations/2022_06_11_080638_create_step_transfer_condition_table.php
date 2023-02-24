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
        Schema::create('step_transfer_condition', function (Blueprint $table) {
            $table->id();
            $table->foreign('step_id')->references('id')->on('process_step')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('step_id')->index()->nullable()->default(null);
            $table->integer('step_condition')->comment('1: AND, 2: OR')->nullable()->default(1);
            $table->integer('step_order')->default(0)->nullable();
            $table->integer('next_step_type')->index()->comment('1: bước đơn lẻ, 2: nhóm bước')->nullable()->default(1);
            $table->bigInteger('group_condition_id')->nullable()->default(null);
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
        Schema::dropIfExists('step_transfer_condition');
    }
};
