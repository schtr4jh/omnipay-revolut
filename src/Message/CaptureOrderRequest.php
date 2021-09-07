<?php

declare(strict_types = 1);

namespace Omnipay\Revolut\Message;

use AbstractRequest;

use function array_merge;

/**
 * Class CaptureOrderRequest
 *
 * @package Omnipay\Revolut\Message
 */
class CaptureOrderRequest extends AbstractRequest
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
        $this->validate('amount');

        return array_merge($this->getCustomData(), [
            'amount' => $this->getAmount(),
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
        $orderId = $this->getOrderId();
        return $this->getUrl().'/orders/'.$orderId.'/capture';
    }
}
