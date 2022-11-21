<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

class CustomerModifyRequest extends CustomerCreateRequest
{
    public function __construct(
        public ?int $customerId,
        ?string $extId,
    ) {
        parent::__construct(extId: $extId);
    }
}
