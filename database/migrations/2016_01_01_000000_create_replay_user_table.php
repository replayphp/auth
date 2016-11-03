<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplayUserTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $table = config("replay.auth.tables.user", "replay_user");

        /** @noinspection PhpUndefinedMethodInspection */
        Schema::create($table, function (Blueprint $table) {

            $table->increments("id");
            $table->string("name");

            /** @noinspection PhpUndefinedMethodInspection */
            $table->string("email")->unique();

            $table->string("password");
            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $table = config("replay.auth.tables.user", "replay_user");

        /** @noinspection PhpUndefinedMethodInspection */
        Schema::drop($table);
    }
}
