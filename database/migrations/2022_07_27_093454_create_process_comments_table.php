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
        Schema::create('process_comments', function (Blueprint $table) {
            $table->id();
            $table->foreign('process_id')->references('id')->on('process')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->unsignedBigInteger('process_id')->index()->nullable()->default(null);
            $table->longText('comment')->nullable()->default(null);
            $table->integer('created_at')->nullable()->default(null);
            $table->integer('updated_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_comments');
    }
};
