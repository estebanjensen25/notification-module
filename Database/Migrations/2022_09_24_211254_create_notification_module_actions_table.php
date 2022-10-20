<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Class CreateNotificationModuleActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_module_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_module_id');
            $table->foreign('notification_module_id')->references('id')->on('notification_modules');
            $table->string('name', 100);
            $table->string('titletext', 250);
            $table->string('bodytext', 250);
            $table->string('urltext', 250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_module_actions');
    }
};
