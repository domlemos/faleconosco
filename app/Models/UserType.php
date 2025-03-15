<?php

namespace App\Models;

class UserType
{
    public static function getUserTypes(): array
    {
        return [
            [
                'label' => 'Administrador',
                'value' => 'admin'
            ],
            [
                'label' => 'Usuário',
                'value' => 'user'
            ]
        ];
    }
}
