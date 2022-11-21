<?php

namespace Muratoffalex\SmartyClient\DTO\Request\Customer;

class CustomerModifyRequest extends CustomerCreateRequest
{
    public function __construct(
        public int $customerId,
        ?string $firstname = null,
        ?string $middlename = null,
        ?string $lastname = null,
        ?\DateTime $birthdate = null,
        ?string $passportNumber = null,
        ?string $passportSeries = null,
        ?\DateTime $passportIssueDate = null,
        ?string $passportIssuedBy = null,
        ?string $postalAddressStreet = null,
        ?string $postalAddressBld = null,
        ?string $postalAddressApt = null,
        ?string $postalAddressZip = null,
        ?string $billingAddressStreet = null,
        ?string $billingAddressBld = null,
        ?string $billingAddressApt = null,
        ?string $billingAddressZip = null,
        ?string $mobilePhoneNumber = null,
        ?string $phoneNumber1 = null,
        ?string $phoneNumber2 = null,
        ?string $faxPhoneNumber = null,
        ?string $email = null,
        ?string $companyName = null,
        ?string $comment = null,
        ?string $extId = null,
        ?int $sendSms = null,
        ?string $bankAccountBiz = null,
        ?string $bankAccountBic = null,
        ?string $bankAccountNumber = null,
        ?string $bankAccountIban = null,
        ?string $bankAccountBankName = null,
        ?string $bankAccountOwnerName = null,
        ?string $contractNumber = null,
        ?string $dealerId = null,
        ?int $sendSmsMessages = null,
        ?int $sendEmailMessages = null,
    )
    {
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->passportNumber = $passportNumber;
        $this->passportSeries = $passportSeries;
        $this->passportIssueDate = $passportIssueDate;
        $this->passportIssuedBy = $passportIssuedBy;
        $this->postalAddressStreet = $postalAddressStreet;
        $this->postalAddressBld = $postalAddressBld;
        $this->postalAddressApt = $postalAddressApt;
        $this->postalAddressZip = $postalAddressZip;
        $this->billingAddressStreet = $billingAddressStreet;
        $this->billingAddressBld = $billingAddressBld;
        $this->billingAddressApt = $billingAddressApt;
        $this->billingAddressZip = $billingAddressZip;
        $this->mobilePhoneNumber = $mobilePhoneNumber;
        $this->phoneNumber1 = $phoneNumber1;
        $this->phoneNumber2 = $phoneNumber2;
        $this->faxPhoneNumber = $faxPhoneNumber;
        $this->email = $email;
        $this->companyName = $companyName;
        $this->comment = $comment;
        $this->extId = $extId;
        $this->sendSms = $sendSms;
        $this->bankAccountBiz = $bankAccountBiz;
        $this->bankAccountBic = $bankAccountBic;
        $this->bankAccountNumber = $bankAccountNumber;
        $this->bankAccountIban = $bankAccountIban;
        $this->bankAccountBankName = $bankAccountBankName;
        $this->bankAccountOwnerName = $bankAccountOwnerName;
        $this->contractNumber = $contractNumber;
        $this->dealerId = $dealerId;
        $this->sendSmsMessages = $sendSmsMessages;
        $this->sendEmailMessages = $sendEmailMessages;
    }
}
