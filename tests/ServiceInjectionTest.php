<?php

namespace go1\util_fn\tests;

use PHPUnit\Framework\TestCase;

class ServiceInjectionTest extends TestCase
{
    public function test()
    {
        exec('echo \'{"name":"world"}\' | php ' . dirname(__DIR__) . '/examples/example-2.php', $output);
        $this->assertContains('Hello world', $output[0]);
        $this->assertContains(date('Y'), $output[0]);
    }
}
