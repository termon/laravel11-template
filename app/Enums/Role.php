<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum Role: string
{
    use EnumOptions;

    case ADMIN = "admin";
    case ACADEMIC = "academic";
    case STUDENT = "student";
    case SUPPORT = "support";
    case GUEST = "guest";
}
