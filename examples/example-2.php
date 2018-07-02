<?php

use go1\util_fn\Fn;

require __DIR__ . '/../Fn.php';

# Example 2: Service injection
# ---------------------
# bash$ echo '{"name":"Andy"}' | php example-2.php
Fn::run(
    function (Fn $fn, stdClass $payload, DateTime $dt) {
        $time = $dt->format(DATE_ISO8601);

        return "[example.2] Hello {$payload->name}! It's $time.\n";
    },
    function () {
        return [
            json_decode(file_get_contents("php://stdin")),
            new DateTime(),
        ];
    }
);
