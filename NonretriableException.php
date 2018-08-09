<?php

namespace go1\util_fn;

use Exception;
use OutOfRangeException;
use Throwable;

class NonretriableException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        if ($code) {
            if ($code < 400 || $code >= 500) {
                throw new OutOfRangeException('Nonretribale: 400 to 499.');
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
