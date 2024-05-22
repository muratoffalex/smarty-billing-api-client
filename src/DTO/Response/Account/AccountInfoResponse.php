<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Account;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;

class AccountInfoResponse extends AbstractResponse
{
    public int $id;
    public int $active;
    public ?string $statusReason;
    public int $autoActivationPeriod;
    public string $extensionDate;
    public string $activationDate;
    public string $deactivationDate;
    public int $allowMultipleLogin;
    public int $allowLoginByAbonement;
    public int $allowLoginByDeviceUid;
    public int $allowLoginByIp;
    public int $parentCode;
    public int $useTimeshift;
    public int $preferredTimeshiftOffset;
    /** @var AccountDevice[] */
    public array $devices;
    /** @var int[] */
    public array $tariffs;
    public int $customerId;
    public string $subnets;
    /** @var AccountSubscription[] */
    public array $subscriptions;
}
