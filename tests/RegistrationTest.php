<?php

namespace Replay\Auth\Test;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Replay\Auth\User;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $redirectAfterRegister;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->prefix = config(
            "replay.auth.route.web.prefix", "replay"
        );

        $this->redirectAfterRegister = config(
            "replay.auth.redirects.register", "replay"
        );
    }

    /**
     * @test
     */
    public function displaysRegistrationForm()
    {
        $this
            ->visit("{$this->prefix}/register")
            ->see("Name")
            ->see("E-Mail Address")
            ->see("Password")
            ->see("Confirm Password");
    }

    /**
     * @test
     */
    public function displaysValidationErrors()
    {
        // check initial validation messages

        $this
            ->visit("{$this->prefix}/register")
            ->press("Register")
            ->see("The name field is required")
            ->see("The email field is required")
            ->see("The password field is required");

        // then check password length

        $this
            ->visit("{$this->prefix}/register")
            ->type("short", "password")
            ->type("short", "password_confirmation")
            ->press("Register")
            ->see("The password must be at least 6 characters");

        // then check password confirmation

        $this
            ->visit("{$this->prefix}/register")
            ->type("T3st3R", "password")
            ->press("Register")
            ->see("The password confirmation does not match");
    }

    /**
     * @test
     */
    public function createsAccount()
    {
        $rand = mt_rand(1, 100);

        $this
            ->visit("{$this->prefix}/register")
            ->type("Tester", "name")
            ->type("tester-{$rand}@gmail.com", "email")
            ->type("T3st3R", "password")
            ->type("T3st3R", "password_confirmation")
            ->press("Register")
            ->seePageIs($this->redirectAfterRegister);

        /** @noinspection PhpUndefinedMethodInspection */
        $user = User::where("email", "tester-{$rand}@gmail.com")->first();

        $this->assertNotNull($user);
        $this->assertEquals("tester-{$rand}@gmail.com", $user->email);
    }
}
