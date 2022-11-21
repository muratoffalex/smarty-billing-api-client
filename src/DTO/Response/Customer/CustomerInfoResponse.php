<?php

namespace Muratoffalex\SmartyClient\DTO\Response\Customer;

use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;

class CustomerInfoResponse extends AbstractResponse
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
