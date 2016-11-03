<?php

namespace Replay\Auth\Http\Controller;

use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class RecoveryController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    use SendsPasswordResetEmails {
        sendResetLinkEmail as previousSendResetLinkEmail;
    }

    use ResetsPasswords {
        reset as previousReset;
    }

    /**
     * @return View
     */
    public function showRequestForm()
    {
        return view(config(
            "replay.auth.views.request", "replay-auth::request"
        ));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function request(Request $request)
    {
        $rules = config("replay.auth.rules.request", function (Request $request) {
            return [
                "email" => "required|email",
            ];
        });

        $this->validate($request, $rules(app("request")));

        $response = $this->broker()->sendResetLink(
            $request->only("email")
        );

        if ($action = config("replay.auth.hooks.request")) {
            $action(app("request"));
        }

        if ($response === Password::RESET_LINK_SENT) {
            return redirect(config(
                "replay.auth.redirects.request", "replay"
            ));
        }

        return back()->withErrors(
            ["email" => trans($response)]
        );
    }

    /**
     * @param Request $request
     * @param null|string $token
     *
     * @return View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view(config(
            "replay.auth.views.reset", "replay-auth::reset"
        ), [
            "token" => $token,
            "email" => $request->email,
        ]);
    }

    /**
     * @return array
     */
    protected function rules()
    {
        $rules = config("replay.auth.rules.reset", function (Request $request) {
            return [
                "token" => "required",
                "email" => "required|email",
                "password" => "required|confirmed|min:6",
            ];
        });

        return $rules(app("request"));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function reset(Request $request)
    {
        $this->previousReset($request);

        if ($action = config("replay.auth.hooks.reset")) {
            $action(app("request"), auth("replay")->user());
        }

        return redirect(config(
            "replay.auth.redirects.reset", "replay"
        ));
    }

    /**
     * @return PasswordBroker
     */
    public function broker()
    {
        /** @var PasswordBrokerManager $manager */
        $manager = app("auth.password");

        return $manager->broker("replay");
    }

    /**
     * @return StatefulGuard
     */
    protected function guard()
    {
        return auth("replay");
    }
}
