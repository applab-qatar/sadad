<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SadadTransLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('applab-sadad.log_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('transable');
            $table->string('sadad_id')->nullable();
            $table->string('status');
            $table->text('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('applab-sadad.log_table'));
    }
}
