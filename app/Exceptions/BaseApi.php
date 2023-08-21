<?php


namespace App\Exceptions;

use Exception;

class BaseApi extends Exception
{
    /**
     * @var int
     */
    protected  $code = 500;
}
