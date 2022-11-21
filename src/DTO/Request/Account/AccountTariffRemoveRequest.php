<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class AccountTariffRemoveRequest extends AbstractRequest
{
    public ?int $accountId;
    public ?int $abonement;
    public ?int $tariffId = null;
    public ?int $vtariffId = null;
    public ?int $tariffExtId = null;

    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        ?int $accountId = null,
        ?int $abonement = null,
        ?int $tariffId = null,
        ?int $vtariffId = null,
        ?int $tariffExtId = null,
    ) {
        if (($accountId === null && $abonement === null) || ($accountId !== null && $abonement !== null)) {
            throw new SmartyClientBaseException('Need customerId OR abonement');
        }

        $this->accountId = $accountId;
        $this->abonement = $abonement;
        $this->tariffId = $tariffId;
        $this->vtariffId = $vtariffId;
        $this->tariffExtId = $tariffExtId;
    }
}
