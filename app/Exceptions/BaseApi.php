<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class BaseApi extends Exception
{
    protected int $code = 500;
}
