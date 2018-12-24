<?php

namespace  Omnipay\Cardconnect\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endPoint = null;

    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        return $this->endPoint = $endPoint . '/cardconnect/rest';
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
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

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function getPaymentProfile()
    {
        return $this->getParameter('payment_profile');
    }

    public function setPaymentProfile($value)
    {
        return $this->setParameter('payment_profile', $value);
    }

    public function getOrderNumber()
    {
        return $this->getParameter('order_number');
    }

    public function setOrderNumber($value)
    {
        return $this->setParameter('order_number', $value);
    }
    
    public function getAccount()
    {
	    return $this->getParameter('account');
    }
	
	public function setAccount($value)
	{
		return $this->setParameter('account', $value);
	}
    
    public function getProfileId()
    {
        return $this->getParameter('profileId');
    }
    
    public function setProfileId($value)
    {
        return $this->setParameter('profileId', $value);
    }

    public function getBillingToken()
    {
        return $this->getParameter('billing_token');
    }

    public function setBillingToken($value)
    {
        return $this->setParameter('billing_token', $value);
    }

    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword())
        ];

        if (!empty($data)) {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $data);
        }
        else {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers);
        }

        try {
            $jsonRes = json_decode($httpResponse->getBody()->getContents(), true);
        }
        catch (\Exception $e){
            info('Guzzle response : ', [$httpResponse]);
            $res = [];
            $res['resptext'] = 'Oops! something went wrong, Try again after sometime.';
            return $this->response = new Response($this, $res);
        }

        return $this->response = new Response($this, $jsonRes);
    }
}

