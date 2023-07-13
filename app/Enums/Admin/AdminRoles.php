<?php

namespace App\Enums\Admin;

use App\Support\Enum;

enum AdminRoles: int
{
    use Enum;

    case SuperAdmin = 1;
    case Admin = 2;
    case Employee = 3;
}
