<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class AccountCreateRequest extends AbstractRequest
{
    public ?int $abonement;
    public ?int $password;
    public ?int $active;
    public ?int $statusReason;
    public ?int $autoActivationPeriod;
    public ?\DateTime $extensionDate;
    public ?\DateTime $activationDate;
    public ?\DateTime $deactivationDate;
    public ?int $allowMultipleLogin;
    public ?int $allowLoginByDeviceUid;
    public ?int $allowLoginByIp;
    public ?int $parentCode;
    public ?int $useTimeshift;
    public ?int $preferredTimeshiftOffset;
    public ?int $dataCenter;
    public ?array $allowedDeviceGroups;
    public ?string $subnets;

    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        public ?int    $customerId = null,
        public ?string $extId = null,
    )
    {
        if (($this->customerId === null && $this->extId === null) || ($this->customerId !== null && $this->extId !== null)) {
            throw new SmartyClientBaseException('Need customerId OR extId');
        }
    }
}
