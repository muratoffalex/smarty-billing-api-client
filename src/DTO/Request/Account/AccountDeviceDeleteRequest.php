<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class AccountDeviceDeleteRequest extends AbstractRequest
{
    public ?int $deviceId;
    public ?string $deviceUid;

    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        ?int    $deviceId = null,
        ?string $deviceUid = null,
    )
    {
        if (($deviceId === null && $deviceUid === null) || ($deviceId !== null && $deviceUid !== null)) {
            throw new SmartyClientBaseException('Need deviceId OR deviceUid');
        }

        $this->deviceId = $deviceId;
        $this->deviceUid = $deviceUid;
    }
}
