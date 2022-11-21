<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;

class CustomerInfoRequest extends AbstractRequest
{
    public function __construct(
        public ?int $customerId = null,
        public ?int $extId = null,
    ) {
    }
}
