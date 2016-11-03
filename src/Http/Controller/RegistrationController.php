<?php

namespace Replay\Auth\Http\Controller;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Replay\Auth\User;

class RegistrationController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    use RegistersUsers {
        register as previousRegister;
    }

    /**
     * @return View
     */
    public function showRegisterForm()
    {
        return view(config(
            "replay.auth.views.register", "replay-auth::register"
        ));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function register(Request $request)
    {
        $this->previousRegister($request);

        return redirect(config(
            "replay.auth.redirects.register", "replay"
        ));
    }

    /**
     * @param array $data
     *
     * @return Validator
     */
    protected function validator(array $data)
    {
        $rules = config("replay.auth.rules.register", function(Request $request) {
            return [
                "name" => "required|max:255",
                "email" => "required|email|max:255|unique:replay_user",
                "password" => "required|min:6|confirmed",
            ];
        });

        return app("validator")->make($data, $rules(app("request")));
    }

    /**
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"]),
        ]);

        if ($action = config("replay.auth.hooks.register")) {
            $action(app("request"), $user);
        }

        return $user;
    }

    /**
     * @return StatefulGuard
     */
    protected function guard()
    {
        return auth("replay");
    }
}
