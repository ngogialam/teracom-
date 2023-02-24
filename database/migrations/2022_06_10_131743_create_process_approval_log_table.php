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
        Schema::create('process_approval_log', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreign('process_id')->references('id')->on('process')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->unsignedBigInteger('process_id')->index();
            $table->integer('approval_status')->nullable()->default(0)->comment('0: dự thảo, 1: chờ phê duyệt/gửi đi, 2: phê duyệt, 3: từ chối');
            $table->longText('comment')->nullable();
            $table->bigInteger('created_by');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->bigInteger('updated_by');
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_approval_log');
    }
};
