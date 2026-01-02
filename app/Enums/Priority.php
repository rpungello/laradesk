<?php

namespace App\Enums;

enum Priority: int
{
    case Emergency = 1;

    case Critical = 2;

    case High = 3;

    case Medium = 4;

    case Low = 5;
}
