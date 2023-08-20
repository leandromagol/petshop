<?php

namespace App\Exceptions;

use Exception;

class BaseApi extends Exception
{
    protected $code = 500;
}
