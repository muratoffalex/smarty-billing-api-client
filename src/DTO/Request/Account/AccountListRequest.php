<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Account;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;

class AccountListRequest extends AbstractRequest
{
    public ?int $status;
    public ?string $statusReason;
    public ?string $device;
    public ?string $abonementRegexp;
    public ?int $limit;
    public ?int $page;

    public function __construct(
        ?int    $status = null,
        ?string $statusReason = null,
        ?string $device = null,
        ?string $abonementRegexp = null,
        ?int    $limit = null,
        ?int    $page = null,
    ) {
        $this->status = $status;
        $this->statusReason = $statusReason;
        $this->device = $device;
        $this->abonementRegexp = $abonementRegexp;
        $this->limit = $limit;
        $this->page = $page;
    }
}
