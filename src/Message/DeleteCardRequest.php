<?php

namespace Omnipay\Cardconnect\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class DeleteCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('cardReference');

        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        try {
            $cardReference = json_decode($this->getCardReference());
            $profileId = $cardReference->profile;
            $acctid = $cardReference->acctid;
            $merchantId = $this->getMerchantId();
        }
        catch (\Exception $e) {
            throw new InvalidRequestException('Invalid payment profile');
        }

        return $this->endPoint = $endPoint . "/cardconnect/rest/profile/{$profileId}/{$acctid}/{$merchantId}";
    }

    public function getHttpMethod()
    {
        return 'DELETE';
    }

    public function getData()
    {
        return "";
    }
}
