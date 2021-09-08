<?php

declare(strict_types = 1);

namespace Omnipay\Revolut\Message;

use function array_merge;
use function json_encode;

/**
 * Class RefundOrderRequest
 *
 * @package Omnipay\Revolut\Message
 */
class RefundOrderRequest extends AbstractRequest
{
    /**
     * Sets the request orderId.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    /**
     * Get the request orderId.
     *
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

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
     * Prepare data to send.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData() : array
    {
        $this->validate('amount', 'currency');

        return array_merge($this->getCustomData(), [
            'amount'                 => $this->getAmount(),
            'currency'               => $this->getCurrency(),
            'merchant_order_ext_ref' => $this->getMerchantOrderReference(),
            'description'            => $this->getDescription(),
        ]);
    }

    /**
     * Send data and return response instance.
     *
     * https://developer.revolut.com/api-reference/merchant/#operation/refundOrder
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
        $orderId = $this->getOrderId();

        return $this->getUrl().'/orders/'.$orderId.'/refund';
    }
}
