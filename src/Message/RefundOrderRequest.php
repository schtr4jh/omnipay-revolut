<?php

declare(strict_types = 1);

namespace Omnipay\Revolut\Message;

use AbstractRequest;

use function array_merge;

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
    public function setMerchantOrderExtRef($value)
    {
        return $this->setParameter('merchantOrderExtRef', $value);
    }

    /**
     * Get the request merchantOrderExtRef.
     *
     * @return mixed
     */
    public function getMerchantOrderExtRef()
    {
        return $this->getParameter('merchantOrderExtRef');
    }

    /**
     * Prepare data to send
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
            'merchant_order_ext_ref' => $this->getMerchantOrderExtRef(),
            'description'            => $this->getDescription(),
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
        return $this->getUrl().'/orders/'.$orderId.'/refund';
    }
}
