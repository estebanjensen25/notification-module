<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Class CreateNotificationNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transmitter_establishment_id');
            $table->foreign('transmitter_establishment_id')->references('id')->on('establishment');
            $table->unsignedBigInteger('transmitter_user_id');
            $table->foreign('transmitter_user_id')->references('id')->on('users');
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('notification_notifications');
    }
};
