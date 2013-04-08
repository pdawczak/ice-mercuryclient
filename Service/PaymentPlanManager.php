<?php

namespace Ice\MercuryClientBundle\Service;

use Ice\MercuryClientBundle\Exception\InvalidPaymentPlanException;
use Ice\MercuryClientBundle\PaymentPlan\AbstractPaymentPlan;
use Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee;

class PaymentPlanManager
{
    /**
     * Returns the payment plan relating to the payment plan code.
     *
     * @param string    $paymentPlanCode
     *
     * @throws \Ice\MercuryClientBundle\Exception\InvalidPaymentPlanException
     * @return AbstractPaymentPlan
     */
    public function getPaymentPlan($paymentPlanCode)
    {
        $mapper = array(
            'residentialRegistrationFee' => new ResidentialRegistrationFee(),
        );

        if (!array_key_exists($paymentPlanCode, $mapper)) {
            throw new InvalidPaymentPlanException;
        }

        return $mapper[$paymentPlanCode];
    }
}
