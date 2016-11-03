<?php

namespace Replay\Auth\Http\Controller;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthenticationController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    use AuthenticatesUsers {
        sendLoginResponse as previousSendLoginResponse;
        logout as previousLogout;
    }

    /**
     * @return View
     */
    public function showLoginForm()
    {
        return view(config(
            "replay.auth.views.login", "replay-auth::login"
        ));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->previousSendLoginResponse($request);

        if ($action = config("replay.auth.hooks.login")) {
            $action(app("request"), auth("replay")->user());
        }

        return redirect(config(
            "replay.auth.redirects.login", "replay"
        ));
    }

    /**
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $rules = config("replay.auth.rules.login", function (Request $request) {
            return [
                "email" => "required|email",
                "password" => "required",
            ];
        });

        $this->validate($request, $rules(app("request")));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        $user = auth("replay")->user();

        $this->previousLogout($request);

        if ($action = config("replay.auth.hooks.logout")) {
            $action(app("request"), $user);
        }

        return redirect(config(
            "replay.auth.redirects.logout", "replay"
        ));
    }

    /**
     * @return StatefulGuard
     */
    protected function guard()
    {
        return auth("replay");
    }
}
