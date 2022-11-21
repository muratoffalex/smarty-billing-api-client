<?php

namespace Muratoffalex\SmartyClient\DTO\Request;

abstract class AbstractRequest implements RequestInterface
{
    public function toArray(): array
    {
        $array = array_filter((array) $this, static fn($value) => $value !== null);

        $arrayWithoutNamespaces = [];
        foreach ($array as $key => $value) {
            $arrayWithoutNamespaces[str_replace(static::class, '', $key)] = $value;
        }

        return $arrayWithoutNamespaces;
    }

    public static function create(): static
    {
        return new static();
    }
}
