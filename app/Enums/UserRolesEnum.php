<?php

namespace App\Enums;

enum UserRolesEnum: int {
    case CARRIER_LEGAL = 1;
    case DRIVER = 2;
    case SHIPPER_LEGAL = 3;
    case SHIPPER_PHYSICAL = 4;
    case ADMINISTRATOR = 5;
    case MODERATOR = 6;
}
