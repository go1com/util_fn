<?php

use go1\util_fn\FnRunner;

require __DIR__ . '/../FnRunner.php';

# Example 2: Service injection
# ---------------------
# bash$ echo '{"name":"Andy"}' | php example-2.php
FnRunner::run(
    function (FnRunner $fn, stdClass $payload, DateTime $dt) {
        $time = $dt->format(DATE_ISO8601);
        return "Hello {$payload->name}! It's $time.\n";
    },
    function (FnRunner $fn) {
        return [
            $fn,
            json_decode(file_get_contents("php://stdin")),
            new DateTime,
        ];
    }
);
