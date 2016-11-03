<?php

namespace Replay\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Replay\Auth\Notification\ResetPassword;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $password_reset_token
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @return string
     */
    public function getTable()
    {
        if (!$this->table) {
            $this->table = config("replay.auth.tables.user", "replay_user");
        }

        return $this->table;
    }

    /**
     * @var array
     */
    protected $fillable = [
        "name",
        "email",
        "password",
    ];

    /**
     * @var array
     */
    protected $hidden = [
        "password",
        "remember_token",
    ];

    /**
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, $this->email));
    }

    /**
     * @return null|string
     */
    public function getPasswordResetTokenAttribute()
    {
        $table = config("replay.auth.tables.password_reset_token", "replay_password_reset_token");

        /** @var array $result */
        $result = app("db")->select(
            "SELECT token FROM {$table} WHERE email = ? ORDER BY created_at DESC LIMIT 1",
            [$this->email]
        );

        if (count($result) > 0) {
            return $result[0]->token;
        }

        return null;
    }
}
