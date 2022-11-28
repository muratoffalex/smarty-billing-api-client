<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Tariff;

class TariffInfo
{
    public int $id;
    public string $name;
    public int $period;
    public int $price;
    public int $activationPrice;
    public int $basicTariffPriority;
    public int $sessionsCount;
    public int $basicSessionsCount;
    public int $ipRestrictions;
    /** @var Channel[] */
    public array $channels;
}
