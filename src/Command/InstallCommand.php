<?php

namespace Replay\Auth\Command;

use Illuminate\Console\Command;
use Replay\Auth\User;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "replay-auth:install {--force}";

    /**
     * @var string
     */
    protected $description = "Install replay/auth files and configuration";

    public function handle()
    {
        $path = config_path("auth.php");

        $force = $this->option("force");

        /** @noinspection PhpIncludeInspection */
        $array = require $path;

        if (!empty($array["guards"]["replay"]) && !$force) {
            $this->warn("It looks like replay/auth is already installed.");
            $this->warn("To continue, add --force to the command.");

            return;
        }

        if (!$force) {
            $this->warn("This command will reformat your config/auth.php file.");
            $this->warn("To continue, add --force to the command.");

            return;
        }

        $array["guards"]["replay"] = [
            "driver" => "session",
            "provider" => "replay",
        ];

        $array["providers"]["replay"] = [
            "driver" => "eloquent",
            "model" => User::class,
        ];

        $array["passwords"]["replay"] = [
            "provider" => "replay",
            "table" => config("replay.auth.tables.password_reset_token", "replay_password_reset_token"),
            "expire" => 60,
        ];

        file_put_contents($path, "<?php return " . var_export($array, true) . ";");

        passthru(sprintf("%s fix %s", base_path("vendor/bin/php-cs-fixer"), $path));
    }
}
