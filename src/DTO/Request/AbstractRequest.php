<?php

namespace Muratoffalex\SmartyClient\DTO\Request;

abstract class AbstractRequest
{
    public function toArray(): array
    {
        return (array) $this;
    }
}