<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Customer;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;

class CustomerCreateResponse extends AbstractResponse
{
    public int $id;
    /** @var string[] */
    public array $errorFields;
}
