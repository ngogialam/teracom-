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
        Schema::create('ticket_approval_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_req_id')->index();
            $table->foreign('ticket_req_id')->references('id')->on('ticket_request')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('approval_status')->comment('0 bản nháp, 1: chờ phê duyệt/gửi đi, 2: phê duyệt, 3: từ chối')
                ->nullable()->default(0);
            $table->longText('comment')->nullable()->default(null);
            $table->bigInteger('created_by');
            $table->integer('created_at');
            $table->integer('updated_at');
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
        Schema::dropIfExists('ticket_approval_log');
    }
};
