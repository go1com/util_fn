<?php

namespace go1\util_fn\tests;

use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    public function test()
    {
        exec('echo \'{"name":"world"}\' | php ' . dirname(__DIR__) . '/examples/hello-world.php', $output);
        $this->assertContains('Hello world', $output[0]);
    }
}
