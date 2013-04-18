<?php

namespace Ice\MercuryClientBundle\Service;

use Ice\MercuryClientBundle\Exception\InvalidPaymentPlanException;
use Ice\MercuryClientBundle\PaymentPlan\AdvancedDiplomaSixInstalments1315February;
use Ice\MercuryClientBundle\PaymentPlan\AdvancedDiplomaSixInstalments1315November;
use Ice\MercuryClientBundle\PaymentPlan\CertificateAndDiplomaThreeInstalments;
use Ice\MercuryClientBundle\PaymentPlan\FullAmountNow;
use Ice\MercuryClientBundle\PaymentPlan\PaymentPlanInterface;
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
     * @return PaymentPlanInterface
     */
    public function getPaymentPlan($paymentPlanCode, $version = '1')
    {
        $paymentPlanName = sprintf("%sV%s", $paymentPlanCode, $version);

        $mapper = array(
            'AdvancedDiplomaSixInstalmentsV1315November' => new AdvancedDiplomaSixInstalments1315November(),
            'AdvancedDiplomaSixInstalmentsV1315February' => new AdvancedDiplomaSixInstalments1315February(),
            'CertificateAndDiplomaThreeInstalmentsV1314' => new CertificateAndDiplomaThreeInstalments(),
            'FullAmountNowV1' => new FullAmountNow(),
            'ResidentialRegistrationFeeV1' => new ResidentialRegistrationFee(),
        );

        if (!array_key_exists($paymentPlanName, $mapper)) {
            throw new InvalidPaymentPlanException(sprintf('Payment plan "%s", version "%s" does not exist', $paymentPlanCode, $version));
        }

        return $mapper[$paymentPlanName];
    }
}
