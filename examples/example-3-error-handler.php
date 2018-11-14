<?php

use go1\util_fn\Fn;

require __DIR__ . '/../Fn.php';

Fn::run(
    function (Fn $fn) {
        $foo = $bar; # yeah, we will have error here; not fatal.

        return "Hello " . ($foo ?? 'world') . "!\n";
    }
);
