<?php

namespace Replay\Auth;

use Illuminate\Support\ServiceProvider;
use Replay\Auth\Provider\CommandProvider;
use Replay\Auth\Provider\ConfigProvider;
use Replay\Auth\Provider\MigrationProvider;
use Replay\Auth\Provider\RouteProvider;
use Replay\Auth\Provider\TestProvider;
use Replay\Auth\Provider\TranslationProvider;
use Replay\Auth\Provider\ViewProvider;

class AuthProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    private $providers = [
        CommandProvider::class,
        ConfigProvider::class,
        MigrationProvider::class,
        RouteProvider::class,
        TestProvider::class,
        TranslationProvider::class,
        ViewProvider::class,
    ];

    public function register()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}
