<?php

namespace go1\util_fn\examples\app;

use go1\util_fn\App;
use Symfony\Component\HttpFoundation\Request;

$app = App::create([
    'paths' => [
        '/hello'      => ['get' => ['operationId' => __DIR__ . '/fn-hello.php']],
        '/bye/{name}' => ['get' => ['operationId' => __DIR__ . '/fn-bye.php']],
        '/error'      => ['post' => ['operationId' => __DIR__ . '/fn-error.php']],
        '/panic'      => ['delete' => ['operationId' => __DIR__ . '/fn-panic.php']],
    ],
]);

if ('cli' === php_sapi_name()) {
    return $app;
}

$req = Request::createFromGlobals();
$app->handle($req);
