<?php

namespace Muratoffalex\SmartyClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Muratoffalex\SmartyClient\DTO\Request\AbstractRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\AddCustomerRequest;
use Muratoffalex\SmartyClient\DTO\Request\Customer\GetCustomerListRequest;
use Psr\Http\Message\ResponseInterface;

class SmartyClient implements SmartyClientInterface
{
    private Client $client;
    private string $billingApiKey;
    private string $clientId;

    public function __construct(
        string $billingApiUrl,
        string $billingApiKey,
        string $clientId,
    ) {
        $this->billingApiKey = $billingApiKey;
        $this->clientId = $clientId;
        $this->client = new Client([
            'base_uri' => $billingApiUrl.'billing/api/',
            'timeout'  => 2,
        ]);
    }

    public function getCustomers(GetCustomerListRequest $request): ResponseInterface
    {
        return $this->request('get', 'customer/list', $request);
    }

    public function addCustomer(AddCustomerRequest $request): ResponseInterface
    {
        return $this->request('post', 'customer/create/', $request);
    }

    /**
     * @throws GuzzleException
     */
    private function request(string $method, string $uri, AbstractRequest $request): ResponseInterface
    {
        $body = $request->toArray();
        $body['clientId'] = $this->clientId;
        $body['signature'] = $this->getSignature($body);

        return $this->client->request($method, $uri, $body);
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
}