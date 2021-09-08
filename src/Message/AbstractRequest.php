<?php

declare(strict_types = 1);

namespace Omnipay\Revolut\Message;

use \Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Class AbstractRequest
 *
 * @package Omnipay\Revolut\Message
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * Gateway production endpoint.
     *
     * @var string $prodEndpoint
     */
    protected $prodEndpoint = 'https://merchant.revolut.com/api/1.0';

    /**
     * @var string $sandboxEndpoint
     */
    protected $sandboxEndpoint = 'https://sandbox-merchant.revolut.com/api/1.0';

    /**
     * @return string
     */
    abstract public function getEndpoint() : string;

    /**
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    abstract public function sendData($data);

    /**
     * Sets the request language.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * Get the request language.
     *
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * Get url. Depends on  test mode.
     *
     * @return string
     */
    public function getUrl() : string
    {
        return $this->getTestMode() ? $this->sandboxEndpoint : $this->prodEndpoint;
    }

    /**
     * Sets the request account ID.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    /**
     * Get the request account ID.
     *
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    /**
     * Sets the request access token.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setAccessToken($value)
    {
        return $this->setParameter('accessToken', $value);
    }

    /**
     * Get the request access token.
     *
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->getParameter('accessToken');
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod() : string
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return [];
    }

    /**
     * /**
     * Set custom data to get back as is.
     *
     * @param array $value
     *
     * @return $this
     */
    public function setCustomData(array $value)
    {
        return $this->setParameter('customData', $value);
    }

    /**
     * Get custom data.
     *
     * @return mixed
     */
    public function getCustomData()
    {
        return $this->getParameter('customData', []) ?? [];
    }
}
