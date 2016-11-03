# Getting Started

To install this package, you need only follow these steps:

## 1. Install with Composer

`replay/auth` is just like any other Composer package, in this regard. Navigate to your application code folder, and run:

```
composer require replay/auth
```

This will install the core files you need.

## 2. Add Service Provider

Like most Laravel packages, `replay/auth` exposes its files and configuration through service providers. Add the main one to your `config/app.php` file:

```php
"providers" => [
    // ...other service providers
    \Replay\Auth\AuthProvider::class,
],
```

You will now be able to use the `auth-replay:*` artisan commands, to perform the rest of the installation steps.

## 3. Install with Artisan

The last thing you need to run is:

```
php artisan replay-auth:install
```

### Be Warned...

Laravel's auth system requires that third-party auth providers need to be added to `config/auth.php`. The `replay-auth:install` command will take care of this for you, but it comes at a cost. Any custom formatting and/or comments will be lost. That's why it requires you to add `--force`.

It won't change any configuration variables, only add the ones `replay/auth` needs. Still, if you like Taylor's comments in your configuration files, you should probably add the config yourself:

```php
"guards" => [
    // ...other guards
    "replay" => [
        "driver" => "session",
        "provider" => "replay",
    ],
],
"providers" => [
    // ...other providers
    "replay" => [
        "driver" => "eloquent",
        "model" => \Replay\Auth\User::class,
    ],
],
"passwords" => [
    // ...other password recovery details
    "replay" => [
        "provider" => "replay",
        "table" => "replay_password_reset_token",
        "expire" => 60,
    ],
],
```

If you want to check these settings, you can [run the tests](testing.md). `replay_password_reset_token` needs to match the name of the password reset token table defined in the migrations. Speaking of migrations...

> If you hit a road-block, grab a fresh `config/auth.php` file from [laravel/laravel](https://github.com/laravel/laravel/blob/master/config/auth.php).

### 4. Running Migrations

This package adds a few database tables to the mix. There are migrations to create these, and once the service provider is installed, you can run these migrations with:

```
php artisan migrate
```
