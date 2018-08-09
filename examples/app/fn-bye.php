<?php

use go1\util_fn\Fn;

return Fn::run(
    function (string $name) {
        return "Bye {$name}!";
    }
);
