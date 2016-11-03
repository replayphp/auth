<?php

namespace Replay\Auth\Provider;

use Illuminate\Support\ServiceProvider;

class ConfigProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            replay_auth_path("config/auth.php") => config_path("replay/auth.php"),
        ], "replay-auth-config");
    }

    public function register()
    {
        $this->mergeConfigFrom(replay_auth_path("config/auth.php"), "replay.auth");
    }
}
