<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Customer;

class CustomerItem
{
    public int $id;
    /** @var CustomerAccount[] */
    public array $accounts;
    /** @var CustomerSubscription[] */
    public array $subscriptions;
    public int $balance;
    public int $paymentsCount;
    /** @var CustomerTariffInfo[] */
    public array $tariffsInfo;
    /** @var CustomerVtariffInfo[] */
    public array $vtariffsInfo;
}
