<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    public function __construct()
    {
        parent::__construct('Bad Request', 400);
    }
}
