<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Tariff;

class TariffModifyRequest extends TariffCreateRequest
{
    public function __construct(
        public int $tariffId,
    ) {
    }
}
