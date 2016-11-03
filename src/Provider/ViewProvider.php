<?php

namespace Replay\Auth\Provider;

use Illuminate\Support\ServiceProvider;

class ViewProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(replay_auth_path("resources/views"), "replay-auth");

        $this->publishes([
            replay_auth_path("resources/views") => resource_path("views/vendor/replay-auth"),
        ], "replay-auth-views");

        $prefix = config("replay.auth.routes.web.prefix", "replay");

        view()->share("isOnLogin", app("request")->is("{$prefix}/login"));
        view()->share("isOnRegister", app("request")->is("{$prefix}/register"));
        view()->share("isOnLogout", app("request")->is("{$prefix}/logout"));
    }
}
