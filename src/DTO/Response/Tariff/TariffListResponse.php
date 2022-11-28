<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Tariff;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;

class TariffListResponse extends AbstractResponse
{
    /** @var TariffInfo[] */
    public array $tariffs;
}
