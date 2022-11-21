<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Account;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;

class AccountListResponse extends AbstractResponse
{
    /** @var AccountInfoResponse[] */
    public array $accounts;
}
