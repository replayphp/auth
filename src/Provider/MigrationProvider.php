<?php

namespace Replay\Auth\Provider;

use Illuminate\Support\ServiceProvider;

class MigrationProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(replay_auth_path("database/migrations"));

        $this->publishes([
            replay_auth_path("database/migrations") => database_path("migrations"),
        ], "replay-auth-migrations");
    }
}
