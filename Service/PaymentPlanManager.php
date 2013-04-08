<?php

namespace Ice\MercuryClientBundle\Service;

use Ice\MercuryClientBundle\Exception\InvalidPaymentPlanException;
use Ice\MercuryClientBundle\PaymentPlan\AbstractPaymentPlan;
use Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee;

class PaymentPlanManager
{
    /**
     * Returns the payment plan relating to the payment plan code and, optionally, version.
     *
     * @param string $paymentPlanCode
     * @param string $version Optional payment plan version
     *
     * @throws \Ice\MercuryClientBundle\Exception\InvalidPaymentPlanException
     * @return AbstractPaymentPlan
     */
    public function getPaymentPlan($paymentPlanCode, $version = '1')
    {
        $mapper = array(
            'residentialRegistrationFee' => array(
                '1' => new ResidentialRegistrationFee(),
            ),
        );

        if (!array_key_exists($paymentPlanCode, $mapper) || !array_key_exists($version, $mapper[$paymentPlanCode])) {
            throw new InvalidPaymentPlanException;
        }

        return $mapper[$paymentPlanCode][$version];
    }
}
