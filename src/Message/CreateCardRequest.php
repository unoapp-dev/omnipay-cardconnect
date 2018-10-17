<?php

namespace Omnipay\Cardconnect\Message;

use Omnipay\Cardconnect\Dictionary\CountryCodesDictionary;
use Omnipay\Cardconnect\Dictionary\ProvinceCodesDictionary;

class CreateCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        return $this->endPoint = $endPoint . '/cardconnect/rest/auth';
    }

    public function getHttpMethod()
    {
        return 'PUT';
    }

    public function getData()
    {
        $data = [];
        $this->getCard()->validate();

        $province = $this->getCard()->getBillingState();
        $provinceCode = array_search(strtolower($province), array_map('strtolower', ProvinceCodesDictionary::$codes));
        $provinceCode = ($provinceCode == false ? "--" : $provinceCode);
        $country = $this->getCard()->getBillingCountry();
        $counryCode = array_search(strtolower($country), array_map('strtolower', CountryCodesDictionary::$codes));


        if($this->getCard()) {
            $data = [
                'merchid' => $this->getMerchantId(),
                'accttype' => $this->getCard()->getBrand(),
                'account' => $this->getCard()->getNumber(),
                'expiry' => $this->getCard()->getExpiryDate('my'),
                'amount' => '0',
                'currency' => $this->getMerchantCurrency(),
                'name' => $this->getCard()->getName(),
                'address' => $this->getCard()->getBillingAddress1(),
                'city' => $this->getCard()->getBillingCity(),
                'region' => $provinceCode,
                'country' => $counryCode,
                'postal' => $this->getCard()->getBillingPostcode(),
                'phone' => $this->getCard()->getBillingPhone(),
                'email' => $this->getCard()->getEmail(),
                'cvv2' => $this->getCard()->getCvv(),
                'tokenize' => 'Y',
                'profile' => 'Y',
                'ecomind' => 'E'
            ];
        }

        return json_encode($data);
    }
}
