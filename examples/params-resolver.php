<?php

use go1\util_fn\Fn;

require __DIR__ . '/../Fn.php';

# Example 2: Service injection
# ---------------------
# bash$ echo '{"name":"Andy"}' | php params-resolver.php
Fn::run(
    function (Fn $fn, stdClass $payload, DateTime $dt) {
        $time = $dt->format(DATE_ISO8601);

        return "Hello {$payload->name}! It's $time.\n";
    },
    function (Fn $fn) {
        return [
            $fn,
            json_decode(file_get_contents("php://stdin")),
            new DateTime,
        ];
    }
);
