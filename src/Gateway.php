<?php

declare(strict_types = 1);

namespace Omnipay\Revolut;

use Omnipay\Common\AbstractGateway;
use Omnipay\Revolut\Message\CancelOrderRequest;
use Omnipay\Revolut\Message\CaptureOrderRequest;
use Omnipay\Revolut\Message\ConfirmOrderRequest;
use Omnipay\Revolut\Message\GetWebhooksRequest;
use Omnipay\Revolut\Message\PurchaseRequest;
use Omnipay\Revolut\Message\RefundOrderRequest;
use Omnipay\Revolut\Message\RetrieveOrderRequest;
use Omnipay\Revolut\Message\SetWebhooksRequest;

/**
 * Braintree Gateway
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
{
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'Revolut';
    }

    /**
     * Get default parameters
     *
     * @return array|mixed
     */
    public function getDefaultParameters()
    {
        return [
            'accountId' => '',
            'accessToken' => '',
        ];
    }

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
     * @return $this
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * Sets the request description.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }

    /**
     * Get the request description.
     *
     * @return $this
     */
    public function getDescription()
    {
        return $this->getParameter('description');
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
     * Set custom data to get back as is
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
     * Get custom data
     *
     * @return mixed
     */
    public function getCustomData()
    {
        return $this->getParameter('customData');
    }

    /**
     * Create a purchase request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    /**
     * Create a confirm request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function completePurchase(array $options = array())
    {
        return $this->createRequest(ConfirmOrderRequest::class, $options);
    }

    /**
     * Create a refund request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function refund(array $options = array())
    {
        return $this->createRequest(RefundOrderRequest::class, $options);
    }

    /**
     * Create a retrieve order request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function fetchTransaction(array $options = array())
    {
        return $this->createRequest(RetrieveOrderRequest::class, $options);
    }

    /**
     * Create a confirm request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function capture(array $options = array())
    {
        return $this->createRequest(CaptureOrderRequest::class, $options);
    }

    /**
     * Create a cancel request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function cancel(array $options = array())
    {
        return $this->createRequest(CancelOrderRequest::class, $options);
    }

    /**
     * Get all webhooks.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function getWebhooks(array $options = array())
    {
        return $this->createRequest(GetWebhooksRequest::class, $options);
    }

    /**
     * Get all webhooks.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function postWebhook(array $options = array())
    {
        return $this->createRequest(SetWebhooksRequest::class, $options);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }
}
