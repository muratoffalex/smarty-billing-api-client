<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class CustomerInfoRequest extends AbstractRequest
{
    public function __construct(
        public ?int $customerId = null,
        public ?int $extId = null,
    ) {
        if (($this->customerId === null && $this->extId === null) || ($this->customerId !== null && $this->extId !== null)) {
            throw new SmartyClientBaseException('Need customerId OR extId');
        }
    }
}
