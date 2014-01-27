<?php

namespace Ice\MercuryClientBundle\Service;

use Ice\MercuryClientBundle\Exception\InvalidPaymentPlanException;
use Ice\MercuryClientBundle\PaymentPlan\MarchAprilMay2014;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1315February;
use Ice\MercuryClientBundle\PaymentPlan\OneYearThreeInstalments1314;
use Ice\MercuryClientBundle\PaymentPlan\FullAmountNow;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;
use Ice\MercuryClientBundle\PaymentPlan\ResidentialRegistrationFee;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1315November;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1315January;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1416February;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1416January;
use Ice\MercuryClientBundle\PaymentPlan\TwoYearSixInstalments1416November;

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
            'AdvancedDiplomaSixInstalmentsV1315January' => new TwoYearSixInstalments1315January(),
            'TwoYearSixInstalmentsV1315January' => new TwoYearSixInstalments1315January(),
            'TwoYearSixInstalmentsV1315February' => new TwoYearSixInstalments1315February(),
            'TwoYearSixInstalmentsV1315October' => new TwoYearSixInstalments1315November(),
            'TwoYearSixInstalmentsV1315November' => new TwoYearSixInstalments1315November(),
            'TwoYearSixInstalmentsV1416January' => new TwoYearSixInstalments1416January(),
            'TwoYearSixInstalmentsV1416February' => new TwoYearSixInstalments1416February(),
            'TwoYearSixInstalmentsV1416October' => new TwoYearSixInstalments1416November(),
            'TwoYearSixInstalmentsV1416November' => new TwoYearSixInstalments1416November(),
            'CertificateAndDiplomaThreeInstalmentsV1314' => new OneYearThreeInstalments1314(),
            'MarchAprilMayV2014' => new MarchAprilMay2014(),
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
