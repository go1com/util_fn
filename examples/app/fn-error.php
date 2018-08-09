<?php

use go1\util_fn\Fn;
use go1\util_fn\RetriableException;

return Fn::run(
    function () {
        throw new RetriableException('Retry later please!');
    }
);
