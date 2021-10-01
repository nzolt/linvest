<?php

namespace App\Exceptions;

use Throwable;

class InvalidInvestException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Invalid investment!';
        parent::__construct($message, $code, $previous);
    }
}