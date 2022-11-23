<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class CustomerTariffRemoveRequest extends AbstractRequest
{
    public function __construct(
        public ?int $customerId = null,
        public ?string $extId = null,
        public ?int $tariffId = null,
        public ?int $vtariffId = null,
        public ?int $tariffExtId = null,
    ) {
        if (($this->customerId === null && $this->extId === null) || ($this->customerId !== null && $this->extId !== null)) {
            throw new SmartyClientBaseException('Need customerId OR extId');
        }

        if (($this->tariffExtId === null && $this->tariffId === null && $this->vtariffId === null) || ($this->tariffExtId !== null && $this->tariffId !== null && $this->vtariffId !== null)) {
            throw new SmartyClientBaseException('Need tariffId OR vtariffId OR tariffExtId');
        }
    }
}
