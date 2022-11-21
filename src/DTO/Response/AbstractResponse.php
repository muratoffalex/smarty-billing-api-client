<?php

namespace Muratoffalex\SmartyClient\DTO\Response;

abstract class AbstractResponse implements ResponseInterface
{
    public int $error;
    public string $errorMessage;
}
