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
use Muratoffalex\SmartyClient\DTO\Request\Account\AccountMessageCreateRequest;
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
use Muratoffalex\SmartyClient\DTO\Request\Tariff\TariffAdditionalListRequest;
use Muratoffalex\SmartyClient\DTO\Request\Tariff\TariffBasicListRequest;
use Muratoffalex\SmartyClient\DTO\Request\Tariff\TariffCreateRequest;
use Muratoffalex\SmartyClient\DTO\Request\Tariff\TariffDeleteRequest;
use Muratoffalex\SmartyClient\DTO\Request\Tariff\TariffListRequest;
use Muratoffalex\SmartyClient\DTO\Request\Tariff\TariffModifyRequest;
use Muratoffalex\SmartyClient\DTO\Response\AbstractResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountCreateResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountDeleteResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountDeviceCreateResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountDeviceDeleteResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountDeviceModifyResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountInfoResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountListResponse;
use Muratoffalex\SmartyClient\DTO\Response\Account\AccountMessageCreateResponse;
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
use Muratoffalex\SmartyClient\DTO\Response\Tariff\TariffAdditionalListResponse;
use Muratoffalex\SmartyClient\DTO\Response\Tariff\TariffBasicListResponse;
use Muratoffalex\SmartyClient\DTO\Response\Tariff\TariffCreateResponse;
use Muratoffalex\SmartyClient\DTO\Response\Tariff\TariffDeleteResponse;
use Muratoffalex\SmartyClient\DTO\Response\Tariff\TariffListResponse;
use Muratoffalex\SmartyClient\DTO\Response\Tariff\TariffModifyResponse;
use Muratoffalex\SmartyClient\Exception\NotSuccessStatusCodeException;
use Muratoffalex\SmartyClient\Exception\SmartyError;
use Muratoffalex\SmartyClient\Exception\SqlServerHasGoneAwayException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *
 */
class SmartyClient implements SmartyClientInterface
{
    /**
     * @var Client
     */
    private Client $client;
    /**
     * @var string
     */
    private string $billingApiKey;
    /**
     * @var int
     */
    private int $clientId;
    /**
     * @var int
     */
    private int $retriesCount;
    /**
     * @var int
     */
    private int $retryCount = 0;
    /**
     * @var bool
     */
    private bool $debug;
    /**
     * @var SerializerInterface|Serializer
     */
    private SerializerInterface $serializer;

    /**
     * @param string $billingApiUrl
     * @param string $billingApiKey
     * @param int $clientId
     * @param int|float $timeout
     * @param int $retriesCount
     * @param bool $debug
     */
    public function __construct(
        string    $billingApiUrl,
        string    $billingApiKey,
        int       $clientId,
        int|float $timeout = 2,
        int       $retriesCount = 0,
        bool      $debug = false
    )
    {
        $this->billingApiKey = $billingApiKey;
        $this->clientId = $clientId;
        $this->client = new Client([
            'base_uri' => $billingApiUrl,
            'timeout' => $timeout,
        ]);
        $this->debug = $debug;
        $this->retriesCount = $retriesCount;

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter()), new ArrayDenormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SqlServerHasGoneAwayException
     * @throws SmartyError
     */
    private function request(string $method, string $uri, AbstractRequest $request, string $responseClass): mixed
    {
        $body = json_decode(
            $this->serializer->serialize($request, 'json', [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]),
            flags: JSON_OBJECT_AS_ARRAY
        );

        $body = $this->postArrayProcessing($body);

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

        // кастомный ретрай
        // ретраим если:
        // - гузли вернул исключение;
        // - статус код не 200;
        // - статус код 200, но код ошибки от смарти = -1;
        try {
            $response = $this->client->request($method, $uri, $options);

            if ($response->getStatusCode() === 200) {
                /** @var AbstractResponse $responseObject */
                $responseObject = $this->serializer->deserialize($response->getBody()->getContents(), $responseClass, 'json');
                if ($responseObject->error === -1) {
                    throw new SqlServerHasGoneAwayException($responseObject->errorMessage . '; code - ' . $responseObject->error, $responseObject->error);
                }

//                if ($responseObject->error !== 0) {
//                    throw new SmartyError($responseObject);
//                }
            } else {
                throw new NotSuccessStatusCodeException($response->getStatusCode(), $uri);
            }
        } catch (NotSuccessStatusCodeException|GuzzleException|SqlServerHasGoneAwayException $exception) {
            if ($this->retriesCount > 0 && $this->retryCount < $this->retriesCount) {
                echo $exception::class . ' retry ' . ($this->retryCount + 1) . PHP_EOL;
                $this->retryCount++;
                return $this->request($method, $uri, $request, $responseClass);
            } else {
                throw $exception;
            }
        }

        $this->retryCount = 0;

        /** @var AbstractResponse */
        return $responseObject;
    }

    /**
     * @param array $array
     * @return array
     */
    public function postArrayProcessing(array $array): array
    {
        foreach ($array as &$item) {
            if (is_array($item)) {
                $item = sprintf('[%s]', implode(', ', $item));
            }
        }

        return $array;
    }

    /**
     * @param array $requestData
     * @return string
     */
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

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return void
     */
    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    /**
     * @param CustomerInfoRequest|null $request
     * @return CustomerInfoResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function customerInfo(?CustomerInfoRequest $request): CustomerInfoResponse
    {
        return $this->request(
            'post',
            'customer/info',
            $request,
            CustomerInfoResponse::class,
        );
    }

    /**
     * @param CustomerListRequest|null $request
     * @return CustomerListResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function customerList(?CustomerListRequest $request): CustomerListResponse
    {
        return $this->request(
            'get',
            'customer/list',
            $request ?? CustomerListRequest::create(),
            CustomerListResponse::class
        );
    }

    /**
     * @param CustomerCreateRequest $request
     * @return CustomerCreateResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function customerCreate(CustomerCreateRequest $request): CustomerCreateResponse
    {
        return $this->request(
            'post',
            'customer/create',
            $request,
            CustomerCreateResponse::class,
        );
    }

    /**
     * @param CustomerModifyRequest $request
     * @return CustomerModifyResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function customerModify(CustomerModifyRequest $request): CustomerModifyResponse
    {
        return $this->request(
            'post',
            'customer/modify',
            $request,
            CustomerModifyResponse::class,
        );
    }

    /**
     * @param CustomerDeleteRequest $request
     * @return CustomerDeleteResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function customerDelete(CustomerDeleteRequest $request): CustomerDeleteResponse
    {
        return $this->request(
            'post',
            'customer/delete',
            $request,
            CustomerDeleteResponse::class,
        );
    }

    /**
     * @param CustomerTariffAssignRequest $request
     * @return CustomerTariffAssignResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function customerTariffAssign(CustomerTariffAssignRequest $request): CustomerTariffAssignResponse
    {
        return $this->request(
            'post',
            'customer/tariff/assign',
            $request,
            CustomerTariffAssignResponse::class,
        );
    }

    /**
     * @param CustomerTariffRemoveRequest $request
     * @return CustomerTariffRemoveResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function customerTariffRemove(CustomerTariffRemoveRequest $request): CustomerTariffRemoveResponse
    {
        return $this->request(
            'post',
            'customer/tariff/remove',
            $request,
            CustomerTariffRemoveResponse::class,
        );
    }

    /**
     * @param AccountCreateRequest $request
     * @return AccountCreateResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountCreate(AccountCreateRequest $request): AccountCreateResponse
    {
        return $this->request(
            'post',
            'account/create',
            $request,
            AccountCreateResponse::class,
        );
    }

    /**
     * @param AccountModifyRequest $request
     * @return AccountModifyResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountModify(AccountModifyRequest $request): AccountModifyResponse
    {
        return $this->request(
            'post',
            'account/modify',
            $request,
            AccountModifyResponse::class,
        );
    }

    /**
     * @param AccountDeleteRequest $request
     * @return AccountDeleteResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountDelete(AccountDeleteRequest $request): AccountDeleteResponse
    {
        return $this->request(
            'post',
            'account/delete',
            $request,
            AccountDeleteResponse::class,
        );
    }

    /**
     * @param AccountInfoRequest $request
     * @return AccountInfoResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountInfo(AccountInfoRequest $request): AccountInfoResponse
    {
        return $this->request(
            'post',
            'account/info',
            $request,
            AccountInfoResponse::class,
        );
    }

    /**
     * @param AccountListRequest $request
     * @return AccountListResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountList(AccountListRequest $request): AccountListResponse
    {
        return $this->request(
            'get',
            'account/list',
            $request,
            AccountListResponse::class,
        );
    }

    /**
     * @param AccountDeviceCreateRequest $request
     * @return AccountDeviceCreateResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountDeviceCreate(AccountDeviceCreateRequest $request): AccountDeviceCreateResponse
    {
        return $this->request(
            'post',
            'account/device/create',
            $request,
            AccountDeviceCreateResponse::class,
        );
    }

    /**
     * @param AccountDeviceCreateRequest $request
     * @return AccountDeviceDeleteResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountDeviceDelete(AccountDeviceCreateRequest $request): AccountDeviceDeleteResponse
    {
        return $this->request(
            'post',
            'account/device/delete',
            $request,
            AccountDeviceDeleteResponse::class,
        );
    }

    /**
     * @param AccountDeviceModifyRequest $request
     * @return AccountDeviceModifyResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountDeviceModify(AccountDeviceModifyRequest $request): AccountDeviceModifyResponse
    {
        return $this->request(
            'post',
            'account/device/modify',
            $request,
            AccountDeviceModifyResponse::class,
        );
    }

    /**
     * @param AccountTariffAssignRequest $request
     * @return AccountTariffAssignResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function accountTariffAssign(AccountTariffAssignRequest $request): AccountTariffAssignResponse
    {
        return $this->request(
            'post',
            'account/tariff/assign',
            $request,
            AccountTariffAssignResponse::class,
        );
    }

    /**
     * @throws NotSuccessStatusCodeException
     * @throws SqlServerHasGoneAwayException
     * @throws GuzzleException
     * @throws SmartyError
     */
    public function accountMessageCreate(AccountMessageCreateRequest $request): AccountMessageCreateResponse
    {
        return $this->request(
            'post',
            'account/message/create',
            $request,
            AccountMessageCreateResponse::class,
        );
    }

    /**
     * @param AccountTariffRemoveRequest $request
     * @return AccountTariffRemoveResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
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
     * @return TariffListResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function tariffList(): TariffListResponse
    {
        return $this->request(
            'post',
            'tariff/list',
            new TariffListRequest(),
            TariffListResponse::class,
        );
    }

    /**
     * @return TariffBasicListResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function tariffBasicList(): TariffBasicListResponse
    {
        return $this->request(
            'post',
            'tariff/basic/list',
            new TariffBasicListRequest(),
            TariffBasicListResponse::class,
        );
    }

    /**
     * @return TariffAdditionalListResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function tariffAdditionalList(): TariffAdditionalListResponse
    {
        return $this->request(
            'post',
            'tariff/additional/list',
            new TariffAdditionalListRequest(),
            TariffAdditionalListResponse::class,
        );
    }

    /**
     * @param TariffCreateRequest $request
     * @return TariffCreateResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function tariffCreate(TariffCreateRequest $request): TariffCreateResponse
    {
        return $this->request(
            'post',
            'tariff/create',
            $request,
            TariffCreateResponse::class,
        );
    }

    /**
     * @param TariffModifyRequest $request
     * @return TariffModifyResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function tariffModify(TariffModifyRequest $request): TariffModifyResponse
    {
        return $this->request(
            'post',
            'tariff/modify',
            $request,
            TariffModifyResponse::class,
        );
    }

    /**
     * @param TariffDeleteRequest $request
     * @return TariffDeleteResponse
     * @throws GuzzleException
     * @throws NotSuccessStatusCodeException
     * @throws SmartyError
     * @throws SqlServerHasGoneAwayException
     */
    public function tariffDelete(TariffDeleteRequest $request): TariffDeleteResponse
    {
        return $this->request(
            'post',
            'tariff/delete',
            $request,
            TariffDeleteResponse::class,
        );
    }
}
