<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;

class CustomerDeleteRequest extends AbstractRequest
{
    public function __construct(
        private ?int $customerId = null,
        private ?string $extId = null,
    ) {
        if (($this->customerId === null && $this->extId === null) || ($this->customerId !== null && $this->extId !== null)) {
            throw new \Exception('Need customerId OR extId');
        }
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @return string|null
     */
    public function getExtId(): ?string
    {
        return $this->extId;
    }
}
