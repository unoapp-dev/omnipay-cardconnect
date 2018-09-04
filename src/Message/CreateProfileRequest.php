<?php

namespace Omnipay\Cardconnect\Message;

use Omnipay\Cardconnect\Dictionary\CountryCodesDictionary;
use Omnipay\Cardconnect\Dictionary\ProvinceCodesDictionary;

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
		    'account' => $this->getAccount(),
            'defaultacct' => 'Y'
	    ];
	    
        $profile = $this->getProfileId();
        $number = $this->getCard()->getNumber();
        $expiry = $this->getCard()->getExpiryDate('my');
        $name = $this->getCard()->getName();
        $address = $this->getCard()->getBillingAddress1();
        $city = $this->getCard()->getBillingCity();
        $phone = $this->getCard()->getBillingPhone();
        $postal = $this->getCard()->getBillingPostcode();
        $email = $this->getCard()->getEmail();
        
        $provinceCode = $this->getCard()->getBillingState();
        if (strlen($provinceCode) != 2) {
            $provinceCode = array_search(strtolower($provinceCode), array_map('strtolower', ProvinceCodesDictionary::$codes));
            $provinceCode = ($provinceCode == false ? "" : $provinceCode);
        }
        
        $counryCode = $this->getCard()->getBillingCountry();
        if (strlen($counryCode) != 2) {
            $counryCode = array_search(strtolower($counryCode), array_map('strtolower', CountryCodesDictionary::$codes));
        }
        
        if (!empty($profile)) $data['profile'] = $profile;
        if (!empty($number)) $data['account'] = $number;
        if (!empty($expiry)) $data['expiry'] = $expiry;
        if (!empty($name)) $data['name'] = $name;
        if (!empty($address)) $data['address'] = $address;
        if (!empty($city)) $data['city'] = $city;
        if (!empty($provinceCode)) $data['region'] = $provinceCode;
        if (!empty($counryCode)) $data['country'] = $counryCode;
        if (!empty($phone)) $data['phone'] = $phone;
        if (!empty($postal)) $data['postal'] = $postal;
        if (!empty($email)) $data['email'] = $email;
        
	    return json_encode($data);
    }
}

