<?php

namespace Omnipay\Cardconnect\Message;

use Omnipay\Cardconnect\Dictionary\CountryCodesDictionary;
use Omnipay\Cardconnect\Dictionary\ProvinceCodesDictionary;
use Omnipay\Common\Exception\InvalidRequestException;

class AuthorizeRequest extends AbstractRequest
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
        $this->validate('amount');

        $data = [
            'merchid'  => $this->getMerchantId(),
            'amount' => $this->getAmount(),
            'orderid' => $this->getOrderNumber(),
            'capture' => 'N'
        ];

        $paymentMethod = $this->getPaymentMethod();

        switch ($paymentMethod)
        {
            case 'card' :
                break;

            case 'payment_profile' :
                if ($this->getCardReference()) {
                    try {
                        $cardReference = json_decode($this->getCardReference());
                        $data['account'] = $cardReference->account;
                        $data['expiry'] = $cardReference->expiry;
                        $data['profile'] = $cardReference->profile;
                        $data['acctid'] = $cardReference->acctid;
                        
                        if ($this->getCard()) {
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
    
                            if (!empty($name)) $data['name'] = $name;
                            if (!empty($address)) $data['address'] = $address;
                            if (!empty($city)) $data['city'] = $city;
                            if (!empty($provinceCode)) $data['region'] = $provinceCode;
                            if (!empty($counryCode)) $data['country'] = $counryCode;
                            if (!empty($phone)) $data['phone'] = $phone;
                            if (!empty($postal)) $data['postal'] = $postal;
                            if (!empty($email)) $data['email'] = $email;
                        }
                    }
                    catch (\Exception $e) {
                        throw new InvalidRequestException('Invalid payment profile');
                    }
                }
                break;

            case 'token' :
                break;

            default :
                break;
        }

        return json_encode($data);
    }
}

