<?php

namespace App\Exceptions;

/**
 *
 */
class TokenNotProvided extends BaseApi
{
/**
 * @var string
 */
    protected $message = 'Token not provided';
/**
 * @var int
 */
    protected $code = 422;
}
