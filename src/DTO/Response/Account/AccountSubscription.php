<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Account;

class AccountSubscription
{
    public int $tariffId;
    public int $apiConfigId;
    public int $price;
    public \DateTime $startDate;
    public \DateTime $endDate;
    public int $isPeriodical;
}
