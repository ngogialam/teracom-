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
        Schema::create('step_checklist', function (Blueprint $table) {
            $table->id();
            $table->foreign('step_id')->references('id')->on('process_step')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('step_id')->index();
            $table->mediumText('content')->nullable()->default(null);
            $table->integer('created_at');
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
        Schema::dropIfExists('step_checklist');
    }
};
