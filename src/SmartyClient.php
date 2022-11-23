<?php

namespace Muratoffalex\SmartyClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountCreateRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountDeleteRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountDeviceCreateRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountDeviceModifyRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountInfoRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountListRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountModifyRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountTariffAssignRequest;
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountTariffRemoveRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerCreateRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerDeleteRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerInfoRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerListRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerModifyRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerTariffAssignRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerTariffRemoveRequest;
use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountCreateResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountDeleteResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountDeviceCreateResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountDeviceDeleteResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountDeviceModifyResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountInfoResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountListResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountModifyResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountTariffAssignResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountTariffRemoveResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerCreateResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerDeleteResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerInfoResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerListResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerModifyResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerTariffAssignResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerTariffRemoveResponse;
use Muratoffalex\SmartyClient\DTO\Response\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SmartyClient implements SmartyClientInterface
{
    private Client $client;
    private string $billingApiKey;
    private int $clientId;

    private bool $debug;

    private SerializerInterface $serializer;

    public function __construct(
        string $billingApiUrl,
        string $billingApiKey,
        int    $clientId,
        bool $debug = false
    )
    {
        $this->billingApiKey = $billingApiKey;
        $this->clientId = $clientId;
        $this->client = new Client([
            'base_uri' => $billingApiUrl,
            'timeout' => 2,
        ]);
        $this->debug = $debug;

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter()), new ArrayDenormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @throws GuzzleException
     */
    private function request(string $method, string $uri, AbstractRequest $request, string $responseClass): mixed
    {
        $body = json_decode(
            $this->serializer->serialize($request, 'json', [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]),
            flags: JSON_OBJECT_AS_ARRAY
        );

        $body['client_id'] = $this->clientId;
        $body['signature'] = $this->getSignature($body);

        $options = [];
        if ($method === 'get') {
            $options['query'] = $body;
        }
        if ($method === 'post') {
            $options['form_params'] = $body;
        }
        if ($this->isDebug()) {
            var_dump($options);
        }

        $response = $this->client->request($method, $uri, $options);

        if ($response->getStatusCode() === 200) {
            $responseObject = $this->serializer->deserialize($response->getBody()->getContents(), $responseClass, 'json');
        }

        /** @var AbstractResponse */
        return $responseObject;
    }

    private function getSignature(array $requestData): string
    {
        ksort($requestData);
        $signature = '';
        foreach ($requestData as $key => $value) {
            $signature .= sprintf('%s:%s;', $key, $value);
        }

        $signature .= $this->billingApiKey;
        $signatureBase64 = base64_encode($signature);

        return md5($signatureBase64);
    }

    public function customerList(?CustomerListRequest $request): CustomerListResponse
    {
        return $this->request(
            'get',
            'customer/list',
            $request ?? CustomerListRequest::create(),
            CustomerListResponse::class
        );
    }

    public function customerInfo(?CustomerInfoRequest $request): CustomerInfoResponse
    {
        return $this->request(
            'post',
            'customer/info',
            $request,
            CustomerInfoResponse::class,
        );
    }

    public function customerCreate(CustomerCreateRequest $request): CustomerCreateResponse
    {
        return $this->request(
            'post',
            'customer/create',
            $request,
            CustomerCreateResponse::class,
        );
    }

    public function customerModify(CustomerModifyRequest $request): CustomerModifyResponse
    {
        return $this->request(
            'post',
            'customer/modify',
            $request,
            CustomerModifyResponse::class,
        );
    }

    public function customerDelete(CustomerDeleteRequest $request): CustomerDeleteResponse
    {
        return $this->request(
            'post',
            'customer/delete',
            $request,
            CustomerDeleteResponse::class,
        );
    }

    public function customerTariffAssign(CustomerTariffAssignRequest $request): CustomerTariffAssignResponse
    {
        return $this->request(
            'post',
            'customer/tariff/assign',
            $request,
            CustomerTariffAssignResponse::class,
        );
    }

    public function customerTariffRemove(CustomerTariffRemoveRequest $request): CustomerTariffRemoveResponse
    {
        return $this->request(
            'post',
            'customer/tariff/remove',
            $request,
            CustomerTariffRemoveResponse::class,
        );
    }

    public function accountCreate(AccountCreateRequest $request): AccountCreateResponse
    {
        return $this->request(
            'post',
            'account/create',
            $request,
            AccountCreateResponse::class,
        );
    }

    public function accountModify(AccountModifyRequest $request): AccountModifyResponse
    {
        return $this->request(
            'post',
            'account/modify',
            $request,
            AccountModifyResponse::class,
        );
    }

    public function accountDelete(AccountDeleteRequest $request): AccountDeleteResponse
    {
        return $this->request(
            'post',
            'account/delete',
            $request,
            AccountDeleteResponse::class,
        );
    }

    public function accountInfo(AccountInfoRequest $request): AccountInfoResponse
    {
        return $this->request(
            'post',
            'account/info',
            $request,
            AccountInfoResponse::class,
        );
    }

    public function accountList(AccountListRequest $request): AccountListResponse
    {
        return $this->request(
            'get',
            'account/list',
            $request,
            AccountListResponse::class,
        );
    }

    public function accountDeviceCreate(AccountDeviceCreateRequest $request): AccountDeviceCreateResponse
    {
        return $this->request(
            'post',
            'account/device/create',
            $request,
            AccountDeviceCreateResponse::class,
        );
    }

    public function accountDeviceDelete(AccountDeviceCreateRequest $request): AccountDeviceDeleteResponse
    {
        return $this->request(
            'post',
            'account/device/delete',
            $request,
            AccountDeviceDeleteResponse::class,
        );
    }

    public function accountDeviceModify(AccountDeviceModifyRequest $request): AccountDeviceModifyResponse
    {
        return $this->request(
            'post',
            'account/device/modify',
            $request,
            AccountDeviceModifyResponse::class,
        );
    }

    public function accountTariffAssign(AccountTariffAssignRequest $request): AccountTariffAssignResponse
    {
        return $this->request(
            'post',
            'account/tariff/assign',
            $request,
            AccountTariffAssignResponse::class,
        );
    }

    public function accountTariffRemove(AccountTariffRemoveRequest $request): AccountTariffRemoveResponse
    {
        return $this->request(
            'post',
            'account/tariff/remove',
            $request,
            AccountTariffRemoveResponse::class,
        );
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     */
    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }
}
