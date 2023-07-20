<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Tariff;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;

class TariffDeleteRequest extends AbstractRequest
{
    public function __construct(public string $tariffId)
    {
    }
}
