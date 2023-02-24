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
        Schema::create('process_change_log', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreign('process_id')->references('id')->on('process')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('process_id')->index();
            $table->string('description', 100)->nullable()->default('');
            $table->bigInteger('created_by');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->bigInteger('updated_by');
            $table->tinyInteger('change_type')->index()->comment('0: trạng thái dự thảo mặc định khi tạo quy trình, 1 : Huỷ kích hoạt, 2: Kích hoạt , 3: Copy phiên bản, 4: Tạo version mới, 5: đổi trạng thái phê duyệt, 6: đổi trạng thái chuyển tiếp, 7: đổi trạng thái gửi duyệt');
            $table->double('version');
            $table->double('old_version');
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
        Schema::dropIfExists('process_change_log');
    }
};
