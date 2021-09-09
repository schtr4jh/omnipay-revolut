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
     * Sets the request merchantOrderExtRef.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setMerchantOrderReference($value)
    {
        return $this->setParameter('merchantOrderReference', $value);
    }

    /**
     * Get the request merchantOrderExtRef.
     *
     * @return mixed
     */
    public function getMerchantOrderReference()
    {
        return $this->getParameter('merchantOrderReference');
    }

    /**
     * Sets the request captureMode.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setCaptureMode($value)
    {
        return $this->setParameter('captureMode', $value);
    }

    /**
     * Get the request captureMode.
     *
     * @return mixed
     */
    public function getCaptureMode()
    {
        return $this->getParameter('captureMode');
    }

    /**
     * Sets the request customerId.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    /**
     * Get the request customerId.
     *
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    /**
     * Sets the request settlementCurrency.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setSettlementCurrency($value)
    {
        return $this->setParameter('settlementCurrency', $value);
    }

    /**
     * Get the request settlementCurrency.
     *
     * @return mixed
     */
    public function getSettlementCurrency()
    {
        return $this->getParameter('settlementCurrency');
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
            'amount'                 => $this->getAmount(),
            'currency'               => $this->getCurrency(),
            'capture_mode'           => $this->getCaptureMode() ?? self::CAPTURE_MODE_AUTOMATIC,
            'merchant_order_ext_ref' => $this->getMerchantOrderReference() ?? null,
            'email'                  => $this->getEmail() ?? null,
            'description'            => $this->getDescription() ?? null,
            'settlement_currency'    => $this->getSettlementCurrency() ?? $this->getCurrency(),
            'customer_id'            => $this->getCustomerId() ?? null,
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
     * Get the order create endpoint.
     *
     * @return string
     */
    public function getEndpoint() : string
    {
        return $this->getUrl().'/orders';
    }
}
