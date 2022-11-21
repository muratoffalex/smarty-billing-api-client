<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Account;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;
use Muratoffalex\SmartyClient\Traits\ErrorFieldsTrait;

class AccountCreateResponse extends AbstractResponse
{
    use ErrorFieldsTrait;

    public string $abonement;
    public string $password;
}
