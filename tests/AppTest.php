<?php

namespace go1\util_fn\tests;

use go1\util_fn\App;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AppTest extends TestCase
{
    public function test()
    {
        /** @var App $app */
        $app = require __DIR__ . '/../examples/app/index.php';

        $hello = $app->handle(Request::create('/hello'));
        $this->assertEquals(200, $hello->getStatusCode());
        $this->assertContains('Hello!', $hello->getContent());

        $bye = $app->handle(Request::create('/bye/John'));
        $this->assertEquals(200, $bye->getStatusCode());
        $this->assertContains('Bye John!', $bye->getContent());

        $error = $app->handle(Request::create('/error', 'POST'));
        $this->assertEquals(500, $error->getStatusCode());
        $this->assertContains('Retry later please!', $error->getContent());

        $panic = $app->handle(Request::create('/panic', 'DELETE'));
        $this->assertEquals(400, $panic->getStatusCode());
        $this->assertContains('Panic!', $panic->getContent());
    }
}
