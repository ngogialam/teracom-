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
        Schema::create('process_step', function (Blueprint $table) {
            $table->id();
            $table->foreign('process_id')->references('id')->on('process')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('process_id')->index();
            $table->mediumText('name');
            $table->integer('action_type')->index()->comment('1 đề xuất, 0: kết thúc, 2 chuyển tiếp, 3: phê duyệt');
            $table->integer('step_type')->index()->comment('1: bước bắt đầu, 0: bước kết thúc, 2: bước quy trình, 3: bước  là 1 quy trình khác');
            $table->integer('step_order');
            $table->unsignedBigInteger('child_process_id')->index()->nullable()->default(null);
            $table->foreign('child_process_id')->references('id')->on('process')->nullable()->default(null)->onDelete('cascade')->onUpdate('cascade');
            $table->integer('sla_quantity')->default(0);
            $table->integer('sla_unit')->default(1)->comment('1: giờ, 2: ngày, 3: ngày làm việc, 4: giờ làm việc');
            $table->integer('transfer_condition_type')->index()->default(1)->comment('1: tất cả đều đúng, 2: 1 trong các đk đúng');
            $table->bigInteger('created_by')->default(0);
            $table->integer('created_at')->default(0);
            $table->integer('updated_at')->nullable()->default(0);
            $table->bigInteger('updated_by')->nullable()->default(0);
            $table->tinyInteger('status')->comment('0 : đang thực hiện, 1: hoàn thành, 2: không duyệt')->default(0);
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
        Schema::dropIfExists('process_step');
    }
};
