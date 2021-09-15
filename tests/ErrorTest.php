<?php

namespace go1\util_fn\tests;

use go1\util_fn\FnRunner;
use go1\util_fn\NonretriableException;
use go1\util_fn\RetriableException;
use PHPUnit\Framework\TestCase;

class ErrorTest extends TestCase
{
    protected function setUp()
    {
        FnRunner::$paramsResolver = function () {
            return [];
        };
    }

    /**
     * @expectedException \OutOfRangeException
     * @expectedExceptionMessage Nonretribale: 400 to 499.
     */
    public function testInvalid4xx()
    {
        FnRunner::run(
            function () {
                throw new NonretriableException('Will have exception!', 123);
            }
        );
    }

    public function test4xx()
    {
        $msg = 'Too bad thing happened.';
        $out = FnRunner::run(
            function () use ($msg) {
                throw new NonretriableException($msg);
            }
        );

        $this->assertEquals('error', $out['type']);
        $this->assertEquals(400, $out['code']);
        $this->assertEquals($msg, $out['message']);
        $this->assertEquals(true, !empty($out['trace']));
    }

    /**
     * @expectedException \OutOfRangeException
     * @expectedExceptionMessage Retribale: 500 to 599.
     */
    public function testInvalid5xx()
    {
        FnRunner::run(
            function () {
                throw new RetriableException('Will have exception!', 123);
            }
        );
    }

    public function test5xx()
    {
        $msg = 'Not too bad thing happened.';
        $out = FnRunner::run(
            function () use ($msg) {
                throw new RetriableException($msg);
            }
        );

        $this->assertEquals('error', $out['type']);
        $this->assertEquals(500, $out['code']);
        $this->assertEquals($msg, $out['message']);
        $this->assertEquals(true, !empty($out['trace']));
    }
}
