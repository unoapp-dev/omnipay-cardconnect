<?php

namespace Omnipay\Cardconnect\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        return $this->endPoint = $endPoint . '/cardconnect/rest/refund';
    }

    public function getHttpMethod()
    {
        return 'PUT';
    }

    public function getData()
    {
        $this->validate('amount', 'transactionReference');

        try {
            $transactionReference = json_decode($this->getTransactionReference());

            $data = [
                'merchid' => $this->getMerchantId(),
                'retref' => $transactionReference->retref,
                'amount' => $this->getAmount()
            ];
        }
        catch (\Exception $e) {
            throw new InvalidRequestException('Invalid transaction reference');
        }

        return json_encode($data);
    }
}
