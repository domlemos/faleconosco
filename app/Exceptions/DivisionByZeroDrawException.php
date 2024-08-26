<?php

namespace App\Exceptions;

use Exception;

class DivisionByZeroDrawException extends Exception
{
    public function __construct()
    {
        parent::__construct('Não há jogadores para realização da partida', 401);
    }
}