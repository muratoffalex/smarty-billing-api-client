<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class CustomerDeleteRequest extends AbstractRequest
{
    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        private ?int $customerId = null,
        private ?string $extId = null,
    ) {
        if (($this->customerId === null && $this->extId === null) || ($this->customerId !== null && $this->extId !== null)) {
            throw new SmartyClientBaseException('Need customerId OR extId');
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
