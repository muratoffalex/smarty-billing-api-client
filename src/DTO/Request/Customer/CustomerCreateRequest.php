<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\Exception\SmartyClientBaseException;

class CustomerCreateRequest extends AbstractRequest
{
    public ?\DateTime $birthdate = null;
    public ?string $passportNumber = null;
    public ?string $passportSeries = null;
    public ?\DateTime $passportIssueDate = null;
    public ?string $passportIssuedBy = null;
    public ?string $postalAddressStreet = null;
    public ?string $postalAddressBld = null;
    public ?string $postalAddressApt = null;
    public ?string $postalAddressZip = null;
    public ?string $billingAddressStreet = null;
    public ?string $billingAddressBld = null;
    public ?string $billingAddressApt = null;
    public ?string $billingAddressZip = null;
    public ?string $mobilePhoneNumber = null;
    public ?string $phoneNumber1 = null;
    public ?string $phoneNumber2 = null;
    public ?string $faxPhoneNumber = null;
    public ?string $email = null;
    public ?string $extId = null;
    public ?int $sendSms = null;
    public ?string $bankAccountBiz = null;
    public ?string $bankAccountBic = null;
    public ?string $bankAccountNumber = null;
    public ?string $bankAccountIban = null;
    public ?string $bankAccountBankName = null;
    public ?string $bankAccountOwnerName = null;
    public ?string $contractNumber = null;
    public ?string $dealerId = null;
    public ?int $sendSmsMessages = null;
    public ?int $sendEmailMessages = null;

    /**
     * @throws SmartyClientBaseException
     */
    public function __construct(
        public ?string $firstname = null,
        public ?string $middlename = null,
        public ?string $lastname = null,
        public ?string $comment = null,
        public ?string $companyName = null,
    )
    {
        if (empty($this->firstname) && empty($this->middlename) && empty($this->lastname) && empty($this->comment) && empty($this->companyName)) {
            throw new SmartyClientBaseException('One of these values must not be empty: firstname, middlename, lastname, comment, companyName');
        }
    }
}
