<?php

namespace Omnipay\Cardconnect\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class InquireRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        $endPoint .= '/cardconnect/rest/inquire';

        $this->validate('transactionReference');

        try {
            $transactionReference = json_decode($this->getTransactionReference());
        }
        catch (\Exception $e) {
            throw new InvalidRequestException('Invalid transaction reference');
        }

        return $this->endPoint = $endPoint. '/' .$transactionReference->retref. '/'. $this->getMerchantId();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function getData()
    {
        $this->validate('transactionReference');

        try {
            $transactionReference = json_decode($this->getTransactionReference());
        }
        catch (\Exception $e) {
            throw new InvalidRequestException('Invalid transaction reference');
        }

        $data = [
            'merchid' => $this->getMerchantId(),
            'retref' => $transactionReference->retref
        ];

        return json_encode($data);
    }
}

