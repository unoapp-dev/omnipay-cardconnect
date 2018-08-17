<?php

namespace Omnipay\Cardconnect\Message;

class CreateProfileRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        return $this->endPoint = $endPoint . '/cardconnect/rest/profile';
    }

    public function getHttpMethod()
    {
        return 'PUT';
    }

    public function getData()
    {
	    $this->validate('account');
	
	    $data = [
		    'merchid' => $this->getMerchantId(),
		    'account' => $this->getAccount()
	    ];
	
	    return json_encode($data);
    }
}

