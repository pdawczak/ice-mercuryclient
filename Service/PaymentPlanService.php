<?php

namespace Ice\MercuryClientBundle\Service;

class PaymentPlanService
{
    /**
     * @param string    $paymentPlanCode
     * @param \DateTime $courseStartDate
     * @param int       $total
     *
     * @return \Ice\MercuryClientBundle\Entity\Receivable[]
     */
    public function getReceivables($paymentPlanCode, \DateTime $courseStartDate, $total)
    {
        $manager = new PaymentPlanManager();
        return $manager
            ->getPaymentPlan($paymentPlanCode)
            ->getReceivables($courseStartDate, $total)
        ;
    }
}
