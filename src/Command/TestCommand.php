<?php

namespace Replay\Auth\Command;

use Illuminate\Console\Command;
use Replay\Auth\Provider\TestProvider;

class TestCommand extends Command
{
    /**nd
     * @var string
     */
    protected $signature = "replay-auth:test {--force}";

    /**
     * @var string
     */
    protected $description = "Run replay/auth tests";

    public function handle()
    {
        $force = $this->option("force");

        if (!$force) {
            $this->warn("This command will replace everything in your tests/replay folders.");
            $this->warn("To continue, add --force to the command.");

            return;
        }

        $cwd = getcwd();
        putenv("REPLAY_BASE_PATH={$cwd}");

        $base = base_path();
        passthru("rm -rf {$base}/tests/replay/auth 2>&1");

        $this->call("vendor:publish", [
            "--tag" => "replay-auth-tests",
            "--provider" => TestProvider::class,
        ]);

        passthru("{$base}/vendor/bin/phpunit {$base}/tests/replay/auth 2>&1");
    }
}
