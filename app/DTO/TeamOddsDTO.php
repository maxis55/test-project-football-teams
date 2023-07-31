<?php

namespace App\DTO;

class TeamOddsDTO
{
    public function __construct(public string $name, public string $odds)
    {
    }
}
