<?php

namespace Replay\Auth\Provider;

use Illuminate\Support\ServiceProvider;
use Replay\Auth\Command\InstallCommand;
use Replay\Auth\Command\TestCommand;

class CommandProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            InstallCommand::class,
            TestCommand::class,
        ]);
    }
}
