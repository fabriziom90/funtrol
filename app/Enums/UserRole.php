<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'superadmin';
    case USER = 'owner';
}
