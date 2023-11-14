<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class AccountMessageCreateRequest extends AbstractRequest
{
    public ?int $abonement;
    public ?int $accountId;
    public ?string $text;
    public ?string $subject;
    public ?int $urgent;
    public ?int $deleteAfterReading;

    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        ?string $subject,
        ?string $text,
        ?int $urgent = 1,
        ?int $deleteAfterReading = 1,
        ?int $accountId = null,
        ?int $abonement = null,
    )
    {
        if (($accountId === null && $abonement === null) || ($accountId !== null && $abonement !== null)) {
            throw new SmartyClientBaseException('Need accountId OR abonement');
        }

        $this->accountId = $accountId;
        $this->abonement = $abonement;
        $this->subject = $subject;
        $this->text = $text;
        $this->urgent = $urgent;
        $this->deleteAfterReading = $deleteAfterReading;
    }
}
