<?php

use go1\util_fn\Fn;

require __DIR__ . '/../Fn.php';

# Example 1: Receive input & write output.
# ---------------------
# bash$ echo '{"name":"Andy"}' | php hello-world.php
Fn::run(
    function (Fn $fn, stdClass $payload) {
        return "Hello {$payload->name}!\n";
    }
);
