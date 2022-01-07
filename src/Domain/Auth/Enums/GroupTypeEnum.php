<?php

namespace Domain\Auth\Enums;

enum GroupTypeEnum: int
{
    case SERVICE = 1;
    case ELDERS = 2;
    case MINISTERIAL_SERVANTS = 3;
    case AUDIO_VIDEO = 4;
    case ATTENDANTS = 5;
    case KHOC = 6;
    case MAINTENANCE = 7;
    case WORKGROUP = 8;
    case SPECIAL = 9;
}
