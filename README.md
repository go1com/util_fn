FN (function) [![Build Status](https://travis-ci.org/go1com/util_fn.svg?branch=master)](https://travis-ci.org/go1com/util_fn)
====

Simple library to build tiny PHP application:

- **Input:** stdIn
- **Output:** stdOut
- No HTTP server.
- No RESTful.

## Usage

```php
<?php

go1\util_fn\FnRunner::run(
    function (go1\util_fn\FnRunner $fn, stdClass $payload) {
        return "Hello {$payload->name}!\n";
    }
);
```

Execute it: `echo '{"name":"world"}' | php hello-world.php`

More examples can be found under `./examples/`.
