# Theming

This package has a handful of views, for each of the user actions it facilitates. They're sparse by design, including as few form and validation elements as possible.

## Customising Views

You can grab a fresh set of views, by running:

```
php artisan vendor:publish --tag=auth-replay-views
```

This will place these views in `resources/views/vendor/replay-auth`. Any changes you make to these will be reflected reflected in the browser. But, perhaps you already have registration and/or login views. In that case...

## Changing View Paths

`replay/auth` is set up to allow you to override which views are loaded. [Create a new config file](configuration.md), and add/change the following values:

```php
"views" => [
    "register", "replay-auth::register",
    "login" => "replay-auth::login",
    "request" => "replay-auth::request",
    "reset", "replay-auth::reset",
    "home", "replay-auth::home",
],
```

`replau-auth::*` refers to any view in the `replay-auth` package, or a custom view in `resources/views/replay-auth`. You can add your custom views to the latter, or pick a new view altogether:

```php
"login" => "my.custom.login",
```

## Using Themes

Maybe you don't want to style everything yourself. To save some time, consider using the standard theme, over at [github.com/replayphp/theme](https://github.com/replayphp/theme).
