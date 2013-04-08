<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;

class ResidentialRegistrationFee extends AbstractPaymentPlan
{
    /**
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        $installment1 = new Receivable();
        $installment1
            ->setAmount($total * 0.15) // 15%
            ->setDueDate(new \DateTime()); // due immediately

        $installment2 = new Receivable();
        $installment2
            ->setAmount($total * 0.85) // 85%
            ->setDueDate($courseStartDate->sub(new \DateInterval("P14D"))); // 2 weeks before course starts

        return array(
            $installment1,
            $installment2
        );
    }
}
