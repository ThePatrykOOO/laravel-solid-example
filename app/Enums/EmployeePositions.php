<?php

namespace App\Enums;

enum EmployeePositions: string
{
    case DIRECTOR = 'director';
    case MANAGER = 'manager';
    case DEVELOPER = 'developer';
    case TESTER = 'tester';
}
