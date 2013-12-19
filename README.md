# Aura.Web_Kernel

Unlike Aura library packages, this Kernel package is *not* intended for
independent use. It exists so it can be embedded in an [Aura.Web_Project][]
created via Composer.  Please see the [Aura.Web_Project][] repository for
more information.

Because this is not an independent package, you cannot run its integration
tests directly. To run the tests:

1. Install [Aura.Web_Project][].

2. Go to the `vendor/aura/web-project/tests` directory.

3. Issue `phpunit` to run the kernel integration tests within the project.

[Aura.Web_Project]: https://github.com/auraphp/Aura.Web_Project
