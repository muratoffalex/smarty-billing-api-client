<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;

class CustomerListRequest extends AbstractRequest
{
    public function __construct(
        public ?int $tariffId = null,
        public ?string $abonementRegexp = null,
        public ?int $limit = null,
        public ?int $page = null,
    )
    {
    }
}
