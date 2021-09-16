<?php

use go1\util_fn\FnRunner;

require __DIR__ . '/../FnRunner.php';

# Example 1: Receive input & write output.
# ---------------------
# bash$ echo '{"name":"Andy"}' | php example-1.php
FnRunner::run(
    function (FnRunner $fn, stdClass $payload) {
        return "Hello {$payload->name}!\n";
    }
);
