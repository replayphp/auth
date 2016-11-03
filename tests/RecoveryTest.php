<?php

namespace Replay\Auth\Test;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use MailThief\Message;
use MailThief\Testing\InteractsWithMail;
use Replay\Auth\User;

class RecoveryTest extends TestCase
{
    use DatabaseTransactions;
    use InteractsWithMail;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $redirectAfterReset;

    /**
     * @var string
     */
    private $redirectAfterLogin;

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

        $this->redirectAfterReset = config(
            "replay.auth.redirects.reset", "replay"
        );

        $this->redirectAfterLogin = config(
            "replay.auth.redirects.login", "replay"
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
    public function displaysRequestForm()
    {
        $this
            ->visit("{$this->prefix}/recovery/request")
            ->see("E-Mail Address");
    }

    /**
     * @test
     */
    public function validatesCredentials()
    {
        $this
            ->visit("{$this->prefix}/recovery/request")
            ->press("Send Password Reset Link")
            ->see("The email field is required");
    }

    /**
     * @test
     */
    public function sendsRecoveryEmail()
    {
        $this
            ->visit("{$this->prefix}/recovery/request")
            ->type($this->user->email, "email")
            ->press("Send Password Reset Link")
            ->seePageIs($this->redirectAfterReset);

        // check what email was sent

        $this->seeMessageFor($this->user->email);
        $this->seeMessageWithSubject("Password Recovery");

        /** @var Message $message */
        $message = $this->lastMessage();

        $link = route("replay.auth.showResetForm", ["token" => $this->user->password_reset_token, "email" => $this->user->email]);

        $this->assertTrue($message->contains($link));
        $this->assertTrue($message->contains("we received a password reset request for your account"));
        $this->assertTrue($message->contains("no further action is required"));
    }

    /**
     * @test
     */
    public function displaysResetForm()
    {
        // request a new token

        $this
            ->visit("{$this->prefix}/recovery/request")
            ->type($this->user->email, "email")
            ->press("Send Password Reset Link");

        // check for fields

        $this
            ->visit("{$this->prefix}/recovery/reset/{$this->user->password_reset_token}")
            ->see("E-Mail Address")
            ->see("Password")
            ->see("Confirm Password");
    }

    /**
     * @test
     */
    public function validatesNewPassword()
    {
        // request a new token

        $this
            ->visit("{$this->prefix}/recovery/request")
            ->type($this->user->email, "email")
            ->press("Send Password Reset Link");

        // check initial validation messages

        $this
            ->visit("{$this->prefix}/recovery/reset/{$this->user->password_reset_token}")
            ->press("Reset Password")
            ->see("The email field is required")
            ->see("The password field is required");

        // then check password length

        $this
            ->visit("{$this->prefix}/recovery/reset/{$this->user->password_reset_token}")
            ->type("short", "password")
            ->type("short", "password_confirmation")
            ->press("Reset Password")
            ->see("The password must be at least 6 characters");

        // then check password confirmation

        $this
            ->visit("{$this->prefix}/recovery/reset/{$this->user->password_reset_token}")
            ->type("T3st3R", "password")
            ->press("Reset Password")
            ->see("The password confirmation does not match");
    }

    /**
     * @test
     */
    public function resetsPassword()
    {
        // request a new token

        $this
            ->visit("{$this->prefix}/recovery/request")
            ->type($this->user->email, "email")
            ->press("Send Password Reset Link");

        // reset password

        $this
            ->visit("{$this->prefix}/recovery/reset/{$this->user->password_reset_token}")
            ->type($this->user->email, "email")
            ->type("T3st3R", "password")
            ->type("T3st3R", "password_confirmation")
            ->press("Reset Password")
            ->seePageIs($this->redirectAfterReset);
    }
}
