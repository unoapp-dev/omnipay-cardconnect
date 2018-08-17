<?php

namespace Omnipay\Cardconnect\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        if (isset($this->data['respstat']) && $this->data['respstat'] == "A")
            return true;

        return false;
    }

    public function getCardReference()
    {
        $token = null;

        $request = json_decode($this->request->getData());

        if (isset($this->data['token'])) {
            $data = [
                'account' => $this->data['token'],
                'expiry' => $request->expiry,
                'profile' => $this->data['profileid'],
                'acctid' => $this->data['acctid']
            ];
            $token = json_encode($data);
        }

        return $token;
    }

    public function getCode()
    {
        return isset($this->data['respcode']) ? $this->data['respcode'] : null;
    }

    public function getAuthCode()
    {
        return isset($this->data['authcode']) ? $this->data['authcode'] : null;
    }

    public function getTransactionId()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    public function getTransactionReference()
    {
        return isset($this->data['retref']) ? $this->data['retref'] : null;
    }

    public function getMessage()
    {
        return isset($this->data['resptext']) ? $this->data['resptext'] : null;
    }

    public function getOrderNumber()
    {
        return isset($this->data['order_number']) ? $this->data['order_number'] : null;
    }
	
	public function getProfileId()
	{
		return isset($this->data['profileid']) ? $this->data['profileid'] : null;
	}
	
	public function getAcctId()
	{
		return isset($this->data['acctid']) ? $this->data['acctid'] : null;
	}

    public function getData()
    {
        return json_encode($this->data);
    }
}
