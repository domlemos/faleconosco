<?php

namespace App\Models;

class SessionData
{
    public function __construct(
        public string $token,
        public string $name,
        public string $type
    ) {
        $this->getAliasType();
    }

    public function getAliasType(): void
    {
        if ($this->type === 'admin') {
            $this->type = 'Administrador';
        }

        if ($this->type === 'user') {
            $this->type = 'Usuário';
        }
    }
}
