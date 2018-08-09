<?php

namespace go1\util_fn;

use Exception;
use OutOfRangeException;

class RetriableException extends Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $code = $code ? $code : 500;
        if ($code < 500 || $code >= 600) {
            throw new OutOfRangeException('Retribale: 500 to 599.');
        }

        parent::__construct($message, $code, $previous);
    }
}
