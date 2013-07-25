<?php

namespace Ice\MercuryClientBundle\Service;

use Ice\MercuryClientBundle\Exception\InvalidPaymentPlanException;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1315February;
use Ice\MercuryClientBundle\PaymentPlan\OneYearThreeInstalments1314;
use Ice\MercuryClientBundle\PaymentPlan\FullAmountNow;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;
use Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1315November;

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
            'AdvancedDiplomaSixInstalmentsV1315November' => new TwoYearSixInstalments1315November(),
            'AdvancedDiplomaSixInstalmentsV1315February' => new TwoYearSixInstalments1315February(),
            'TwoYearSixInstalmentsV1315February' => new TwoYearSixInstalments1315November(),
            'TwoYearSixInstalmentsV1315November' => new TwoYearSixInstalments1315November(),
            'CertificateAndDiplomaThreeInstalmentsV1314' => new OneYearThreeInstalments1314(),
            'OneYearThreeInstalmentsV1314' => new OneYearThreeInstalments1314(),
            'FullAmountNowV1' => new FullAmountNow(),
            'ResidentialRegistrationFeeV1' => new ResidentialRegistrationFee(),
        );

        if (!array_key_exists($paymentPlanName, $mapper)) {
            throw new InvalidPaymentPlanException(sprintf('Payment plan "%s", version "%s" does not exist', $paymentPlanCode, $version));
        }

        return $mapper[$paymentPlanName];
    }
}
