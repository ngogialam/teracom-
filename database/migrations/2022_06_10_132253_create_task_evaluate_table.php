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
        Schema::create('task_evaluate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->index();
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('process_id')->index();
            $table->foreign('process_id')->references('id')->on('process')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('step_id')->index();
            $table->foreign('step_id')->references('id')->on('process_step')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('rate');
            $table->longText('comment')->nullable()->default(null);
            $table->bigInteger('created_by');
            $table->integer('created_at');
            $table->integer('updated_at')->nullable()->default(null);
            $table->bigInteger('updated_by');
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
        Schema::dropIfExists('task_evaluate');
    }
};
