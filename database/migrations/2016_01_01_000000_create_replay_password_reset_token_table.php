<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplayPasswordResetTokenTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $table = config("replay.auth.tables.password_reset_token", "replay_password_reset_token");

        /** @noinspection PhpUndefinedMethodInspection */
        Schema::create($table, function (Blueprint $table) {

            /** @noinspection PhpUndefinedMethodInspection */
            $table->string("email")->index();

            /** @noinspection PhpUndefinedMethodInspection */
            $table->string("token")->index();

            /** @noinspection PhpUndefinedMethodInspection */
            $table->timestamp("created_at")->nullable();

        });
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $table = config("replay.auth.tables.password_reset_token", "replay_password_reset_token");

        /** @noinspection PhpUndefinedMethodInspection */
        Schema::drop($table);
    }
}
