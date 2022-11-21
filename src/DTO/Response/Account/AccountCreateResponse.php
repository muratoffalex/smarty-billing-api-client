<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Account;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;

class AccountCreateResponse extends AbstractResponse
{
    public string $abonement;
    public string $password;
    public string $errorFields;
}
