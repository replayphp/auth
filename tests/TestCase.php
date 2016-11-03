<?php

namespace Replay\Auth\Test;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var string
     */
    protected $baseUrl = "http://localhost";

    /**
     * @return Application
     */
    public function createApplication()
    {
        if ($path = getenv("REPLAY_BASE_PATH")) {
            /** @noinspection PhpIncludeInspection */
            $app = require "{$path}/bootstrap/app.php";
        } else {
            /** @noinspection PhpIncludeInspection */
            $app = require __DIR__ . "/../../../../bootstrap/app.php";
        }

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
