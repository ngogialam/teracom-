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
        Schema::create('step_object', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('step_id')->index()->nullable()->default(null);
            $table->foreign('step_id')->references('id')->on('process_step')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('object_action_type')->index()->default(1)
                ->comment('1 thực hiện step, 2: chỉ nhận thông tin step, 3 người phê duyệt)');
            $table->integer('object_type')->index()->nullable()->default(null);
            $table->bigInteger('object_id')->nullable()->default(null);
            $table->mediumText('object_name')->nullable()->default(null)->nullable()->default(null);
            $table->string('object_position', 100)->nullable()->default(null);
            $table->integer('created_at')->nullable()->default(null);
            $table->integer('deleted_at')->nullable()->default(null);
            $table->integer('status')->default(1)->nullable();
            $table->unsignedBigInteger('process_id')->index()->nullable();
            $table->foreign('process_id')->references('id')->on('process')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('active')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step_object');
    }
};
