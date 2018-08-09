<?php

use go1\util_fn\Fn;
use go1\util_fn\NonretriableException;

return Fn::run(
    function () {
        throw new NonretriableException('Panic!');
    }
);
