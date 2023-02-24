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
        Schema::table('task_object', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id')->nullable()->default(null)->change();
            $table->unsignedBigInteger('ticket_req_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_object', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id')->index()->change();
            $table->unsignedBigInteger('ticket_req_id')->index()->change();
        });
    }
};
