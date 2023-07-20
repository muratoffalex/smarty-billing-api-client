<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Tariff;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;

class TariffCreateRequest extends AbstractRequest
{
    public ?string $name = null;
    public ?float $period = null;
    public ?string $price = null;
    public ?string $defaultActivationPrice = null;
    public ?int $enabled = null;
    public ?int $assignedByDefault = null;
    public ?int $required = null;
    public ?int $sessionsCount = null;
    public ?int $ipRestriction = null;
    public ?int $basicSessionsCount = null;
    public ?int $basicTariffPriority = null;
    public ?int $availableForInactiveAccounts = null;
    public ?int $availableEverywhere = null;
    public ?int $displayInChannelsWidget = null;
    public ?int $usedForChannelList = null;
    public ?int $usedForVideoList = null;
    public ?int $usedForRadioList = null;
    public ?int $availableToUnsubscribe = null;

    public function __construct(
        string $name,
        int $period = 0,
        int $basicTariffPriority = 0,
        int $sessionsCount = -1,
        int $basicSessionsCount = -1,
    ) {
        $this->name = $name;
        $this->period = $period;
        $this->basicTariffPriority = $basicTariffPriority;
        $this->sessionsCount = $sessionsCount;
        $this->basicSessionsCount = $basicSessionsCount;
    }
}
