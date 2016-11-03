<?php

namespace Replay\Auth\Provider;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class RouteProvider extends ServiceProvider
{
    public function boot()
    {
        /** @var Application $app */
        $app = $this->app;

        if (!$app->routesAreCached()) {

            /** @var Router $router */
            $router = app("router");

            /** @noinspection PhpIncludeInspection */
            $router->group([
                "prefix" => config(
                    "replay.auth.routes.web.prefix", "replay"
                ),
                "middleware" => config(
                    "replay.auth.routes.web.middleware", ["web"]
                ),
            ], require replay_auth_path("routes/web.php"));

        }
    }
}
