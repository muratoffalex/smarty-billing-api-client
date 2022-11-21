<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Account;

class AccountDevice
{
    public int $id;
    public string $systemName;
    public string $deviceUid;
    public string $serialNumber;
    public string $createdAt;
    public int $isBasic;
}
