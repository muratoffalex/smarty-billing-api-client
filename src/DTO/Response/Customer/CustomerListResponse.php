<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Customer;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;

class CustomerListResponse extends AbstractResponse
{
    /** @var CustomerItem[] */
    public array $customers;
}
