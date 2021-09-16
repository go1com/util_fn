<?php

use go1\util_fn\FnRunner;

require __DIR__ . '/../FnRunner.php';

FnRunner::run(
    function (FnRunner $fn) {
        $foo = $bar; # yeah, we will have error here; not fatal.
        return "Hello " . ($foo ?? 'world') . "!\n";
    }
);
