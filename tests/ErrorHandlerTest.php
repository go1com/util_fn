<?php

namespace go1\util_fn\tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class ErrorHandlerTest extends TestCase
{
    public function test()
    {
        $log = [];

        $process = new Process('php ' . __DIR__ . '/../examples/example-3-error-handler.php');
        $process->run(
            function ($type, $output) use (&$log) {
                $log[$type][] = $output;
            }
        );

        $this->assertContains('Hello world!', $log['out'][0]);
        $this->assertContains('Undefined variable: bar', $log['err'][0]);
    }
}
