<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class AccountDeviceCreateRequest extends AbstractRequest
{
    public ?int $accountId;
    public ?int $abonement;
    public string $systemName;
    public string $deviceUid;
    public ?string $serialNumber;
    public ?string $brandName;
    public ?string $diagonal;
    public ?string $resetSettings;

    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        string      $systemName,
        string      $deviceUid,
        ?int $accountId = null,
        ?int $abonement = null,
    )
    {
        if (($accountId === null && $abonement === null) || ($accountId !== null && $abonement !== null)) {
            throw new SmartyClientBaseException('Need customerId OR abonement');
        }

        $this->accountId = $accountId;
        $this->abonement = $abonement;
        $this->systemName = $systemName;
        $this->deviceUid = $deviceUid;
    }
}
