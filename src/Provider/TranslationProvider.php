<?php

namespace Replay\Auth\Provider;

use Illuminate\Support\ServiceProvider;

class TranslationProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(replay_auth_path("resources/lang"), "replay");

        $this->publishes([
            replay_auth_path("resources/lang") => resource_path("lang/vendor/replay"),
        ], "replay-auth-lang");
    }
}
