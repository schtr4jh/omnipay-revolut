<?php

declare(strict_types = 1);

namespace Omnipay\Revolut\Message;

use AbstractRequest;
use Omnipay\Arca\Message\Response;

use function array_merge;

/**
 * Class PurchaseRequest
 *
 * @package Omnipay\Revolut\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Prepare data to send
     *
     * @return array
     */
    public function getData()
    {
        /**
         * {
         * "request_id": "string",
         * "account_id": "449e7a5c-69d3-4b8a-aaaf-5c9b713ebc65",
         * "receiver": {
         * "counterparty_id": "fd38dae9-b300-4017-a630-101c4279eafd",
         * "account_id": "449e7a5c-69d3-4b8a-aaaf-5c9b713ebc65"
         * },
         * "amount": 0,
         * "currency": "string",
         * "reference": "string",
         * "schedule_for": "2019-08-24"
         * }
         */
        $this->validate('currency', 'amount', 'accountId', 'accessToken');

        return array_merge($this->getCustomData(), [

            'request_id' => $this->getTransactionId(),
            'account_id' => $this->getAccountId(),
            'amount'     => $this->getAmount(),
            'currency'   => $this->getCurrency(),
            'reference'  => $this->getTransactionReference(),
            'receiver'   => [
                'counterparty_id' => '',
                'account_id'      => $this->getAccountId()
            ]

        ]);
    }

    /**
     * Send data and return response instance
     *
     * @param mixed $body
     *
     * @return mixed
     */
    public function sendData($body)
    {
        //here manipulate the request and pass the data to server
        $headers = [
            'Authorization' => 'Bearer '.$this->getAccessToken(),
        ];

        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $body);

        return $this->createResponse($httpResponse->getBody()->getContents(), $httpResponse->getHeaders());
    }

    /**
     * @param       $data
     * @param array $headers
     *
     * @return Response
     */
    protected function createResponse($data, $headers = []) : Response
    {
        return $this->response = new Response($this, $data, $headers);
    }

    /**
     * @return string
     */
    public function getEndpoint() : string
    {
        return $this->getUrl().'/orders';
    }
}
