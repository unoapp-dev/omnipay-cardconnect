<?php

namespace Omnipay\Cardconnect\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        return $this->endPoint = $endPoint . '/cardconnect/rest/capture';
    }

    public function getHttpMethod()
    {
        return 'PUT';
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

