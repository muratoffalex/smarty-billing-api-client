<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

class AccountModifyRequest extends AccountCreateRequest
{
    public function __construct(
        public ?int $accountId = null,
        ?int $abonement = null,
    ) {
        $this->abonement = $abonement;
    }
}
