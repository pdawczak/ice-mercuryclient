<?php

namespace Ice\MercuryClientBundle\Service;

class PaymentPlanService
{
    /**
     * @param string    $paymentPlanCode Code of payment plan
     * @param string    $version         Payment plan rules version
     * @param \DateTime $courseStartDate Date course starts
     * @param int       $total           Total amount owed by booker
     *
     * @return \Ice\MercuryClientBundle\Entity\Receivable[]
     */
    public function getReceivables($paymentPlanCode, $version, \DateTime $courseStartDate, $total)
    {
        $manager = new PaymentPlanManager();
        return $manager
            ->getPaymentPlan($paymentPlanCode, $version)
            ->getReceivables($courseStartDate, $total);
    }

    /**
     * @param string    $paymentPlanCode Code of payment plan
     * @param string    $version         Payment plan rules version
     *
     * @return \Ice\MercuryClientBundle\PaymentPlan\PaymentPlanInterface
     */
    public function getPaymentPlan($paymentPlanCode, $version)
    {
        $manager = new PaymentPlanManager();
        return $manager->getPaymentPlan($paymentPlanCode, $version);
    }
}
