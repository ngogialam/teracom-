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
        Schema::create('ticket_request', function (Blueprint $table) {
            $table->id();
            $table->mediumText('name');
            $table->bigInteger('department_id');
            $table->unsignedBigInteger('process_id')->index();
            $table->foreign('process_id')->references('id')->on('process')->onDelete('cascade')->onUpdate('cascade');
            $table->string('ticket_serial')->nullable()->default(null);
            $table->integer('request_time')->nullable()->default(null);
            $table->integer('finish_time')->nullable()->default(null);
            $table->tinyInteger('priority')->default(1)->comment(' 1: thấp, 2 : trung bình, 3: cao');
            $table->longText('comment')->nullable()->default(null);
            $table->integer('ticket_action')->comment('1: không làm gì, 2: chuyển tiếp cho người bắt đầu quy trình')
                ->nullable()->default(1);
            $table->integer('approval_status')->comment('0: dự thảo, 1: đang xử lý, 2: hoàn thành, 3: từ chối')
                ->nullable()->default(0);
            $table->bigInteger('created_by')->nullable()->default(null);
            $table->integer('created_at')->nullable()->default(null);
            $table->tinyInteger('complete')->default(1)->nullable()->comment('1:Đang thực hiện, 2:Hoàn thành');
            $table->integer('updated_at')->nullable()->default(null);
            $table->bigInteger('updated_by')->nullable()->default(null);
            $table->integer('deleted_at')->nullable()->default(null);
            $table->tinyInteger('ticket_type')->default(1)->nullable()
                ->comment('1: Phiếu yêu cầu thường, 2: Phiếu yêu cầu tự động');
            $table->string('code')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_request');
    }
};
