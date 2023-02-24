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
        Schema::create('process', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->mediumText('name');
            $table->string('short_name', 50);
            $table->bigInteger('owner_deparment_id');
            $table->integer('target_apply_type')->index()->comment('1: toàn hệ thống, 2: nội bộ');
            $table->mediumText('regulation_document')->nullable()->default("");
            $table->integer('regulation_start_date')->nullable()->default(0);
            $table->integer('regulation_end_date')->nullable()->default(0);
            $table->longText('description')->default("");
            $table->integer('approval_status')->index()->default(1)
                ->comment('1: bản nháp, 2: chờ phê duyệt/gửi đi, 3: phê duyệt, 4: từ chối,5: hết hiệu lực');
            $table->integer('approval_target_type')->default(1)->index()->comment('1: một người, 2: một nhóm');
            $table->integer('deleted_at')->nullable()->default(null);
            $table->double('version')->default(1);
            $table->bigInteger('created_by');
            $table->integer('created_at');
            $table->unsignedBigInteger('process_id')->comment('id của quy trình cũ')->nullable();
            $table->integer('updated_at')->nullable()->default(null);
            $table->bigInteger('updated_by')->nullable()->default(null);
            $table->tinyInteger('status')->default(1)->comment('1: Kích hoạt, 0: Ngừng kích hoạt');
            $table->integer('required_time')->nullable()->default(null);
            $table->integer('request_completion_time')->nullable()->default(null);
            $table->tinyInteger('out_of_date')->default(0)->nullable()->comment('0: là trong hạn,1: là quá hạn');
            $table->integer('activation_date')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process');
    }
};
