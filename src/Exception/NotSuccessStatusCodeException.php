<?php

namespace Muratoffalex\SmartyClient\Exception;

use Throwable;

class NotSuccessStatusCodeException extends SmartyClientBaseException
{
    public function __construct($code, string $method, Throwable $previous = null)
    {
        parent::__construct("Smarty api request error: method = $method; status code = $code", $code, $previous);
    }
}
