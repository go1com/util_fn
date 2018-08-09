<?php

namespace go1\util_fn\examples\swagger;

use go1\util_fn\App;

require __DIR__ . '/../../vendor/autoload.php';

App::run([
    'paths' => [
        '/hello'      => [
            'get' => [
                'operationId' => '%/hello/fn.php',
            ],
        ],
        '/bye/{name}' => [
            'get' => [
                'operationId' => '%/bye/fn.php',
            ],
        ],
    ],
]);
