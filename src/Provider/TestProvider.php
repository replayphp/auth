<?php

namespace Replay\Auth\Provider;

use Illuminate\Support\ServiceProvider;

class TestProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            replay_auth_path("tests") => base_path("tests/replay/auth"),
        ], "replay-auth-tests");
    }
}
