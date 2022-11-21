<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Customer;

class CustomerSubscription
{
    public int $tariffId;
    public int $apiConfigId;
    public int $price;
    public \DateTime $startDate;
    public \DateTime $entDate;
    public int $isPeriodical;
    public \DateTime $priceExpiration;
    public int $isPriceOverriden;
    public int $isClosed;
}
