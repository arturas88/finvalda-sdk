<?php

declare(strict_types=1);

namespace Finvalda\Enums;

enum AccessResult: string
{
    case Success = 'Success';
    case Fail = 'Fail';
    case AccessDenied = 'AccessDenied';
}
