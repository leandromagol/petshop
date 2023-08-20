<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 *
 */
class TokenNotProvided extends BaseApi
{
    protected string $message = 'Token not provided';
    protected int $code = 422;
}
