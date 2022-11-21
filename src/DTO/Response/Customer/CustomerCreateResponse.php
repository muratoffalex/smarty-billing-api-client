<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Customer;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;
use Muratoffalex\SmartyClient\Traits\ErrorFieldsTrait;

class CustomerCreateResponse extends AbstractResponse
{
    use ErrorFieldsTrait;

    public int $id;
}
