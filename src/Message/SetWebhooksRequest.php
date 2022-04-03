<?php

declare(strict_types=1);

namespace Omnipay\Revolut\Message;

use function array_merge;
use function json_encode;

/**
 * Class RetrieveOrderRequest
 *
 * @package Omnipay\Revolut\Message
 */
class SetWebhooksRequest extends AbstractRequest
{
    public function getData()
    {
        return [];
    }

    /**
     * Send data and return response instance.
     *
     * https://developer.revolut.com/api-reference/merchant/#operation/retrieveOrder
     *
     * @param mixed $body
     *
     * @return mixed
     */
    public function sendData($body)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json'
        ];

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            json_encode($body)
        );

        return $this->createResponse($httpResponse->getBody()->getContents(), $httpResponse->getHeaders());
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @param       $data
     * @param array $headers
     *
     * @return Response
     */
    protected function createResponse($data, $headers = []): Response
    {
        return $this->response = new Response($this, $data, $headers);
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->getUrl() . '/webhooks';
    }
}
