<?php

declare(strict_types = 1);

namespace Omnipay\Revolut\Message;

use function array_merge;

/**
 * Class ConfirmOrderRequest
 *
 * @package Omnipay\Revolut\Message
 */
class ConfirmOrderRequest extends AbstractRequest
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
     * Prepare data to send
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('paymentMethod');

        return array_merge($this->getCustomData(), [
            'payment_method_id' => $this->getPaymentMethod(),
        ]);
    }

    /**
     * Send data and return response instance
     *
     * https://developer.revolut.com/api-reference/merchant/#operation/confirmOrder
     *
     * @param mixed $body
     *
     * @return \Omnipay\Revolut\Message\Response
     */
    public function sendData($body) : Response
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

        return $this->getUrl().'/orders/'.$orderId.'/confirm';
    }
}
