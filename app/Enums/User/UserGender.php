<?php

namespace App\Enums\User;

use App\Support\Enum;

enum UserGender: int
{
    use Enum;

    case Male = 1;
    case Female = 2;
    case Other = 3;
}
