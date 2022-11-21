<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class AccountDeviceModifyRequest extends AbstractRequest
{
    public ?string $deviceId;
    public ?string $deviceUid;
    public ?string $serialNumber;
    public ?string $brandName;
    public ?string $diagonal;
    public ?string $resetSettings;

    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        ?int $deviceId = null,
        ?int $deviceUid = null,
    )
    {
        if (($deviceId === null && $deviceUid === null) || ($deviceId !== null && $deviceUid !== null)) {
            throw new SmartyClientBaseException('Need deviceUid OR deviceId');
        }

        $this->deviceId = $deviceId;
        $this->deviceUid = $deviceUid;
    }
}
