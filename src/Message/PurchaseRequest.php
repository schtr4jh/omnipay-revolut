<?php

declare(strict_types = 1);

namespace Omnipay\Revolut\Message;

use function array_merge;
use function json_encode;

/**
 * Class PurchaseRequest
 *
 * @package Omnipay\Revolut\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Sets the counterPartyId.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setCounterPartyId($value)
    {
        return $this->setParameter('counterPartyId', $value);
    }

    /**
     * Get the counterPartyId.
     *
     * @return mixed
     */
    public function getCounterPartyId()
    {
        return $this->getParameter('counterPartyId');
    }

    /**
     * Prepare the data for creating the order.
     *
     * https://developer.revolut.com/api-reference/merchant/#operation/createOrder
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('currency', 'amount');

        return array_merge($this->getCustomData(), [
            'request_id' => $this->getTransactionId(),
            'account_id' => $this->getAccountId(),
            'amount'     => $this->getAmount(),
            'currency'   => $this->getCurrency(),
            'reference'  => $this->getTransactionReference(),
            'receiver'   => [
                'counterparty_id' => $this->getCounterPartyId(),
                'account_id'      => $this->getAccountId()
            ]
        ]);
    }

    /**
     * Send data and return response instance.
     *
     * @param mixed $body
     *
     * @return mixed
     */
    public function sendData($body)
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->getAccessToken(),
            'Content-Type'  => 'application/json'
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
