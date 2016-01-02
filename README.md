# Google Forms URL Generator

> Generate URLs for Google Forms that are prepoluated and ready to submit.


## Getting Started

This project uses Composer to handle dependencies for the project. Once you
have Composer installed, you can run `composer install` to bring in the
project's dependencies.


## Testing

You can run the tests for the application with `vendor/bin/phpunit tests/`.

If you'd like to watch the project files and rerun the tests when files are
changed, you can run:

```bash
fswatch -o src/*.php tests/*.php | xargs -n1 -I{} vendor/bin/phpunit tests/ --bootstrap vendor/autoload.php
```
