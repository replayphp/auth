<?php

if (!function_exists("replay_auth_path")) {
    /**
     * @param null|string $path
     *
     * @return string
     */
    function replay_auth_path($path = null) {
        if ($path !== null) {
            return __DIR__ . "/../{$path}";
        }

        return __DIR__ . "/../";
    }
}