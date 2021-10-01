<?php

namespace App\Exceptions;

use Throwable;

class InvalidAmountException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Invalid amount in virtual valet!';
        parent::__construct($message, $code, $previous);
    }
}