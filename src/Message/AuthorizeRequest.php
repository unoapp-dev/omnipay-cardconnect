<?php

namespace Omnipay\Cardconnect\Message;

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

