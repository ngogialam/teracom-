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
        Schema::create('task_object', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->index();
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('object_action_type')->index()
                ->comment('1 thực hiện step, 2: chỉ nhận thông tin step, 3 người phê duyệt)')
                ->nullable()->default(1);
            $table->integer('object_type')->index();
            $table->bigInteger('object_id');
            $table->mediumText('object_name')->nullable();
            $table->string('object_position', 100)->nullable()->default(null);
            $table->bigInteger('created_by');
            $table->integer('created_at');
            $table->integer('updated_at')->nullable()->default(null);
            $table->bigInteger('updated_by');
            $table->integer('deleted_at')->nullable()->default(null);
            $table->foreign('ticket_req_id')->references('id')->on('ticket_request')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ticket_req_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_object');
    }
};
