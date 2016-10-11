# Contributing to the PHP Fluent WebDriver Client

## Our Development Process

Some of our core contributors will be working directly on GitHub. These changes will be public from the beginning.

### `master` changes fast

We move fast and most likely things will break. Every time there is a commit our CI server will run the tests and hopefully they will pass all times. We will do our best to properly communicate the changes that can affect the application API and always version appropriately in order to make easier for you to use a specific version.

### Pull Requests

The core contributors will be monitoring for pull requests. When we get one, we will pull it in and apply it to our codebase and run our test suite to ensure nothing breaks. Then one of the core contributors needs to verify that all is working appropriately. When the API changes we may need to fix internal uses, which could cause some delay. We'll do our best to provide updates and feedback throughout the process.

*Before* submitting a pull request, please make sure the following is done:

1. Fork the repo and create your branch from `master`.
2. If you've added code that should be tested, add tests!
3. If you've changed APIs, update the documentation.
4. Ensure the test suite passes.


## Bugs

### Where to Find Known Issues

We will be using GitHub Issues for our public bugs. We will keep a close eye on this and try to make it clear when we have an internal fix in progress. Before filing a new task, try to make sure your problem doesn't already exist.

### Reporting New Issues

The best way to get your bug fixed is to provide a reduced test case.

## How to Get in Touch

Glitter Room: https://gitter.im/athena-oss/Lobby

## Development best practices

We are using [PSR-2](http://www.php-fig.org/psr/psr-2/) coding style for our development, so please apply it as well if you want to contribute.

## License

By contributing to PHP Fluent WebDriver Client, you agree that your contributions will be licensed under the [Apache License Version 2.0 (APLv2)](LICENSE).
