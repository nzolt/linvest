<?php

namespace App\Exceptions;

use Throwable;

class InvalidTranchException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Tranch didn\'t exist';
        parent::__construct($message, $code, $previous);
    }
}