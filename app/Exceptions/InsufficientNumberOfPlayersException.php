<?php

namespace App\Exceptions;

use Exception;

class InsufficientNumberOfPlayersException extends Exception
{
    public function __construct()
    {
        parent::__construct('Quantidade insuficiente de Jogadores', 401);
    }
}
