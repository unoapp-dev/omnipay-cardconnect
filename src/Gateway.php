<?php

namespace Omnipay\CardConnect;

use Omnipay\Common\AbstractGateway;

/**
 * Cardconnect Gateway
 * @link https://developer.cardconnect.com/cardconnect-api?lang=json
 */

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Cardconnect';
    }

    public function getDefaultParameters()
    {
        return [
            'sandboxEndPoint' => '',
            'productionEndPoint' => '',
            'merchantId' => '',
            'merchantCurrency' => '',
            'username' => '',
            'password' => ''
        ];
    }

    public function getSandboxEndPoint()
    {
        return $this->getParameter('sandboxEndPoint');
    }

    public function setSandboxEndPoint($value)
    {
        return $this->setParameter('sandboxEndPoint', $value);
    }

    public function getProductionEndPoint()
    {
        return $this->getParameter('productionEndPoint');
    }

    public function setProductionEndPoint($value)
    {
        return $this->setParameter('productionEndPoint', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getMerchantCurrency()
    {
        return $this->getParameter('merchantCurrency');
    }

    public function setMerchantCurrency($value)
    {
        return $this->setParameter('merchantCurrency', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\CreateCardRequest', $parameters);
    }

    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\DeleteCardRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\RefundRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\CaptureRequest', $parameters);
    }
	
	public function createProfile(array $parameters = array())
	{
		return $this->createRequest('\Omnipay\Cardconnect\Message\CreateProfileRequest', $parameters);
	}
}

