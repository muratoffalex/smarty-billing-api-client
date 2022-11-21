<?php

namespace Muratoffalex\SmartyClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerCreateRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerDeleteRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerInfoRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\CustomerListRequest;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerCreateResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerDeleteResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerInfoResponse;
use Muratoffalex\SmartyClient\DTO\Response\Customer\CustomerListResponse;
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

    private SerializerInterface $serializer;

    public function __construct(
        string $billingApiUrl,
        string $billingApiKey,
        int    $clientId,
    )
    {
        $this->billingApiKey = $billingApiKey;
        $this->clientId = $clientId;
        $this->client = new Client([
            'base_uri' => $billingApiUrl,
            'timeout' => 2,
        ]);

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter()), new ArrayDenormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function customerList(?CustomerListRequest $request): CustomerListResponse
    {
        return $this->request(
            'get',
            'customer/list/',
            $request ?? CustomerListRequest::create(),
            CustomerListResponse::class
        );
    }

    /**
     * @throws GuzzleException
     */
    private function request(string $method, string $uri, AbstractRequest $request, string $responseClass): ResponseInterface
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

        $response = $this->client->request($method, $uri, $options);

        if ($response->getStatusCode() === 200) {
            $responseObject = $this->serializer->deserialize($response->getBody()->getContents(), $responseClass, 'json');
        }

        /** @var ResponseInterface */
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

    public function customerInfo(?CustomerInfoRequest $request)
    {
        return $this->request(
            'get',
            'customer/info',
            $request ?? CustomerInfoRequest::create(),
            CustomerInfoResponse::class,
        );
    }

    public function customerCreate(CustomerCreateRequest $request): CustomerCreateResponse
    {
        return $this->request(
            'post',
            'customer/create/',
            $request,
            CustomerCreateResponse::class,
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

//    public function addCustomer(CustomerCreateRequest $request): ResponseInterface
//    {
//        return $this->request('post', 'customer/create/', $request);
//    }
}
