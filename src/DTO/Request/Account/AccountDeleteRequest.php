<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class AccountDeleteRequest extends AbstractRequest
{
    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        public ?int $accountId = null,
        public ?int $abonement = null,
    ) {
        if (($this->accountId === null && $this->abonement === null) || ($this->accountId !== null && $this->abonement !== null)) {
            throw new SmartyClientBaseException('Need customerId OR abonement');
        }
    }
}
