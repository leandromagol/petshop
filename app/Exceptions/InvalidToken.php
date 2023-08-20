<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 *
 */
class InvalidToken extends BaseApi
{
    protected int $code = 422;
}
