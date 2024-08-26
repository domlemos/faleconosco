<?php

namespace App\Exceptions;

use Exception;

class MaximumPlayersException extends Exception
{
    public function __construct()
    {
        parent::__construct('Número máximo de jogadores por partida excedido', 401);
    }
}
