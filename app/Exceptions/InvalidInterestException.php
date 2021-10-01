<?php

namespace App\Exceptions;

use Throwable;

class InvalidInterestException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Invalid interest! Interest can\'t be negative';
        parent::__construct($message, $code, $previous);
    }
}