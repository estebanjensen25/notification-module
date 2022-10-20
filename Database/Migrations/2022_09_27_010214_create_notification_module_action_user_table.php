<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Class CreateNotificationModuleActionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_module_action_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_module_action_id');
            $table->foreign('notification_module_action_id', 'not_module_action_user_module_action_id_foreign')->references('id')->on('notification_module_actions');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('notification_channel_id');
            $table->foreign('notification_channel_id')->references('id')->on('notification_channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_module_action_user');
    }
};
