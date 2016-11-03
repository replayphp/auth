<?php

namespace Replay\Auth\Test;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Replay\Auth\User;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $redirectAfterLogin;

    /**
     * @var string
     */
    private $redirectAfterLogout;

    /**
     * @var User
     */
    private $user;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->prefix = config(
            "replay.auth.route.web.prefix", "replay"
        );

        $this->redirectAfterLogin = config(
            "replay.auth.redirects.login", "replay"
        );

        $this->redirectAfterLogout = config(
            "replay.auth.redirects.logout", "replay"
        );

        $rand = mt_rand(1, 100);

        $this->user = User::create([
            "name" => "Tester",
            "email" => "tester-{$rand}@gmail.com",
            "password" => bcrypt("T3st3R"),
        ]);
    }

    /**
     * @test
     */
    public function displaysLoginForm()
    {
        $this
            ->visit("{$this->prefix}/login")
            ->see("E-Mail Address")
            ->see("Password");
    }

    /**
     * @test
     */
    public function validatesCredentials()
    {
        // check bad email

        $rand = mt_rand(1, 100);

        $this
            ->visit("{$this->prefix}/login")
            ->type("missing-user-{$rand}@gmail.com", "email")
            ->type("bad password", "password")
            ->press("Login")
            ->see("These credentials do not match our records");

        // check bad password

        $this
            ->visit("{$this->prefix}/login")
            ->type($this->user->email, "email")
            ->type("bad password", "password")
            ->press("Login")
            ->see("These credentials do not match our records");
    }

    /**
     * @test
     */
    public function logsIn()
    {
        $this
            ->visit("{$this->prefix}/login")
            ->type($this->user->email, "email")
            ->type("T3st3R", "password")
            ->press("Login")
            ->seeIsAuthenticated("replay")
            ->seePageIs($this->redirectAfterLogin);
    }

    /**
     * @test
     */
    public function logsOut()
    {
        // first log the user in

        auth("replay")->login($this->user);

        // then try to log out

        $this
            ->seeIsAuthenticated("replay")
            ->post("{$this->prefix}/logout")
            ->dontSeeIsAuthenticated("replay");
    }
}
