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
        Schema::table('process_step', function (Blueprint $table) {
            //
            $table->tinyInteger('timesheet')->default(0)->comment('0:không, 1:có');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('process_step', function (Blueprint $table) {
            //
            $table->dropColumn('timesheet');
        });
    }
};
