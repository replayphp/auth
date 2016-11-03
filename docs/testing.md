# Testing

This package comes with a full set of integration tests, so you can be sure what you install continues to work long after you've customised it.

## Getting New Tests

Begin testing by getting a fresh set of the bundled tests:

```
php artisan replay-auth:test
```

> You'll note: this command asks you to add `--force`. That's because it removes any tests you already have in `tests/replay/*`, and copies new ones there. You only have to do this once, as you'll be able to run tests "normally" thereafter.

## Running Tests

Once the tests have been copied into `tests/replay/*`, you no longer need to run the `replay-auth:test` command. You can continue to run:

```
vendor/bin/phpunit
```

...as you normally would. Of course, if you don't care about customising the behaviour of `replay/auth`, you can just overwrite the tests every time.
