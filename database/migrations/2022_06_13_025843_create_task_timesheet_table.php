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
        Schema::create('task_timesheet', function (Blueprint $table) {
            $table->id();
            $table->integer('work_time');
            $table->integer('number_working');
            $table->integer('number_actual_time');
            $table->string('note', 400)->nullable();
            $table->integer('created_at');
            $table->integer('updated_at')->nullable()->default(null);
            $table->integer('deleted_at')->nullable()->default(null);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->foreign('process_id')->references('id')->on('process')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('process_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taske_timesheet');
    }
};
