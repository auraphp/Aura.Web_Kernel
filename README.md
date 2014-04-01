# Aura.Web_Kernel

Provides the core files for an [Aura.Web_Project][].

## Requirements

This kernel requires PHP 5.4 or later. Unlike Aura library packages, this
kernel package is *not* intended for independent use. It exists so it can be
embedded in an [Aura.Web_Project][] created via [Composer][].

Please see the [Aura.Web_Project][] repository for more information.

## Tests

[![Build Status](https://travis-ci.org/auraphp/Aura.Web_Kernel.png?branch=develop-2)](https://travis-ci.org/auraphp/Aura.Web_Kernel)

This kernel has 100% code coverage with [PHPUnit][].

The included tests are integration tests, not unit tests. To run them, change
to the `tests/` directory and issue `.integration.sh`.

## PSR Compliance

This kernel attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If
you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
[PHPUnit]: http://phpunit.de/manual/
[Composer]: http://getcomposer.org
[Aura.Web_Project]: https://github.com/auraphp/Aura.Web_Project
