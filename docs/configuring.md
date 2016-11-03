# Configuring

There are quite a few customisation you can make, aside from [theming](theming.md). You can create a new `config/replay/auth.php` file, or run:

```
php artisan vendor:publish --tag=replay-auth-config
```

This config file defines customisable values for the following areas...

## Middleware and Routes

Would you like to change the Replay route prefix? How about the middleware applied to the Replay routes? Just change:

```php
"routes" => [
    "web" => [
        "prefix" => "replay",
        "middleware" => ["web"],
    ],
],
```

## Redirects

Each of the user actions (login, registration etc.) can have custom redirect URLs. Perhaps you'd like your users to be send to a custom thanks page, after sign-up? Just change:

```php
"redirects" => [
    "register" => "replay",
    "login" => "replay",
    "logout" => "replay",
    "request" => "replay",
    "reset" => "replay",
    "authenticated" => "replay",
    "unauthenticated" => "replay",
],
```

> Each of these defaults or the same URL as the `replay/auth` home page. You can pick any URL in the application. If you'd like to redirect to an external site, define a route which will return `RedirectResponse`.

## Views

If you'd like to load your own views, in place of the ones `replay/auth` expects, you can customise:

```php
"views" => [
    "register", "replay-auth::register",
    "login" => "replay-auth::login",
    "request" => "replay-auth::request",
    "reset", "replay-auth::reset",
    "home", "replay-auth::home",
],
```

You can do a lot [more theme customisation](theming.md)...

## Database Tables

`replay/auth` includes a few database migrations. You can customise the table names that are used, with:

```php
"tables" => [
    "password_reset_token" => "replay_password_reset_token",
    "user" => "replay_user",
],
```

> If you change these, after you've already migrated and run `replay-auth:install`, you'll need to do both of those things again. You may also need to adjust the validation rules...

## Validation Rules

If you need to change or add custom validation rules, you can access all the ones `replay/auth` uses:

```php
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
```

You have full access to the current request, so you can fetch any session/GET/POST data from that, to build up the rule arrays. Be sure to keep `unique:replay_user` in sync, if you rename the database tables.

## Hooks

Sometimes you may want to perform some action right after a user registers, or logs in. You can add any of the following hooks:

```php
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
```

> These all happen directly after the corresponding actions. It's not practical to get a `\Replay\Auth\User` object, during the password reset request step, so you'll have to make do without, or infer the target user based on the request parameters.
