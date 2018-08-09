<?php

namespace go1\util_fn\tests;

use go1\util_fn\App;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AppTest extends TestCase
{
    public function test()
    {
        $app = App::create([
            'paths' => [
                '/hello'      => ['get' => ['operationId' => __DIR__ . '/../examples/swagger-app/hello.php']],
                '/bye/{name}' => ['get' => ['operationId' => __DIR__ . '/../examples/swagger-app/bye.php']],
            ],
        ]);

        $this->assertEquals('Hello!', $app->handle(Request::create('/hello')));
        $this->assertEquals('Bye John!', $app->handle(Request::create('/bye/John')));
    }
}
