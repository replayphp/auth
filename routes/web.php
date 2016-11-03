<?php

use Illuminate\Routing\Router;
use Replay\Auth\Http\Controller\AuthenticationController;
use Replay\Auth\Http\Controller\RecoveryController;
use Replay\Auth\Http\Controller\RegistrationController;
use Replay\Auth\Http\Middleware\RedirectIfAuthenticated;

/**
 * @param Router $router
 */
return function (Router $router) {
    $router->group([
        "middleware" => RedirectIfAuthenticated::class,
    ], function () use ($router) {
        $router->get("/login", [
            "uses" => AuthenticationController::class . "@showLoginForm",
            "as" => "replay.auth.showLoginForm",
        ]);

        $router->post("/login", [
            "uses" => AuthenticationController::class . "@login",
            "as" => "replay.auth.login",
        ]);

        $router->get("/register", [
            "uses" => RegistrationController::class . "@showRegisterForm",
            "as" => "replay.auth.showRegisterForm",
        ]);

        $router->post("/register", [
            "uses" => RegistrationController::class . "@register",
            "as" => "replay.auth.register",
        ]);

        $router->get("/recovery/request", [
            "uses" => RecoveryController::class . "@showRequestForm",
            "as" => "replay.auth.showRequestForm",
        ]);

        $router->post("/recovery/request", [
            "uses" => RecoveryController::class . "@request",
            "as" => "replay.auth.request",
        ]);

        $router->get("/recovery/reset/{token}", [
            "uses" => RecoveryController::class . "@showResetForm",
            "as" => "replay.auth.showResetForm",
        ]);

        $router->post("/recovery/reset", [
            "uses" => RecoveryController::class . "@reset",
            "as" => "replay.auth.reset",
        ]);
    });

    $router->post("/logout", [
        "uses" => AuthenticationController::class . "@logout",
        "as" => "replay.auth.logout",
    ]);

    $router->get("/", function () {
        return view(config(
            "replay.auth.views.home", "replay-auth::home"
        ));
    })->name("replay.auth.home");
};
