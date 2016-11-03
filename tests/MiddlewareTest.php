<?php

namespace Replay\Auth\Test;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Replay\Auth\User;

class MiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $redirectAfterIsAuthenticated;

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

        $this->redirectAfterIsAuthenticated = config(
            "replay.auth.redirects.authenticated", "replay"
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
    public function redirectsWhenAuthenticated()
    {
        // first log the user in

        auth("replay")->login($this->user);

        // then check for redirects from replay.guest middleware

        $this
            ->seeIsAuthenticated("replay")
            ->visit("{$this->prefix}/login")
            ->seePageIs($this->redirectAfterIsAuthenticated);

        $this
            ->seeIsAuthenticated("replay")
            ->visit("{$this->prefix}/register")
            ->seePageIs($this->redirectAfterIsAuthenticated);

        $this
            ->seeIsAuthenticated("replay")
            ->visit("{$this->prefix}/recovery/request")
            ->seePageIs($this->redirectAfterIsAuthenticated);
    }
}
