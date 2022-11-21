<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;

class GetCustomerListRequest extends AbstractRequest
{
    public function __construct(
        public ?int $tariffId,
        public ?string $abonementRegexp,
        public ?int $limit,
        public ?int $page,
    )
    {
    }
}