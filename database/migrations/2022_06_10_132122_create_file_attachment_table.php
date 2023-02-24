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
        Schema::create('file_attachment', function (Blueprint $table) {
            $table->id();
            $table->mediumText('file_name');
            $table->bigInteger('file_uid')->nullable();
            $table->foreignId('target_id')->index()->unsigned()->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('target_type')->index()->comment('1: quy trinh, 2 nhiem vu, 3: buoc, 4: Phiếu yêu cầu')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->string('path');
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('file_attachment');
    }
};
