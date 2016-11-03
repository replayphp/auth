<?php

return [
    "routes" => [
        "web" => [
            "prefix" => "replay",
            "middleware" => ["web"],
        ],
    ],
    "redirects" => [
        "register" => "replay",
        "login" => "replay",
        "logout" => "replay",
        "request" => "replay",
        "reset" => "replay",
        "authenticated" => "replay",
        "unauthenticated" => "replay",
    ],
    "views" => [
        "register", "replay-auth::register",
        "login" => "replay-auth::login",
        "request" => "replay-auth::request",
        "reset", "replay-auth::reset",
        "home", "replay-auth::home",
    ],
    "tables" => [
        "password_reset_token" => "replay_password_reset_token",
        "user" => "replay_user",
    ],
    "rules" => [
        "register" => function(\Illuminate\Http\Request $request) {
            return [
                "name" => "required|max:255",
                "email" => "required|email|max:255|unique:replay_user",
                "password" => "required|min:6|confirmed",
            ];
        },
        "login" => function(\Illuminate\Http\Request $request) {
            return [
                "email" => "required|email",
                "password" => "required",
            ];
        },
        "request" => function(\Illuminate\Http\Request $request) {
            return [
                "email" => "required|email",
            ];
        },
        "reset" => function(\Illuminate\Http\Request $request) {
            return [
                "token" => "required",
                "email" => "required|email",
                "password" => "required|confirmed|min:6",
            ];
        },
    ],
    "hooks" => [
        "register" => function(\Illuminate\Http\Request $request, \Replay\Auth\User $user) {
            // ...do something after register
        },
        "login" => function(\Illuminate\Http\Request $request, \Replay\Auth\User $user) {
            // ...do something after login
        },
        "logout" => function(\Illuminate\Http\Request $request, \Replay\Auth\User $user) {
            // ...do something after logout
        },
        "request" => function(\Illuminate\Http\Request $request) {
            // ...do something after password reset request
        },
        "reset" => function(\Illuminate\Http\Request $request, \Replay\Auth\User $user) {
            // ...do something after password reset
        },
    ],
];
