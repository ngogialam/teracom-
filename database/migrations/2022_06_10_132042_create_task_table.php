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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_req_id')->index();
            $table->foreign('ticket_req_id')->references('id')->on('ticket_request')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('step_id')->index();
            $table->foreign('step_id')->references('id')->on('process_step')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('task_type')->index()->comment('1: task bình thường do người dùng tạo, 2: task tự động');
            $table->bigInteger('assignee_id');
            $table->bigInteger('department_id');
            $table->integer('actual_complete_time')->nullable();
            $table->integer('expected_complete_time');
            $table->integer('action')->comment('1: không làm gì, 2: chuyển tiếp cho người bắt đầu quy trình, 3: phê duyệt');
            $table->integer('approval_status')->comment('0 bản nháp, 1: chờ phê duyệt/gửi đi, 2: phê duyệt, 3: từ chối');
            $table->unsignedBigInteger('rollback_step_id')->index();
            $table->foreign('rollback_step_id')->references('id')->on('process_step')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('rollback_type')->index()->comment('1: chỉ quay lại bước chỉ định, 2: quay lại và thực hiện tuần tự');
            $table->longText('comment')->nullable()->default("");
            $table->bigInteger('created_by')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->integer('status')->default(1)->comment('1: Đang triển khai, 2: Đã hoàn thành, 3: Đã đóng');
            $table->integer('auto_ticket_req_id')->nullable();
            $table->string('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
};
