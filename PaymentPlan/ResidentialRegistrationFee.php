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
        $instalment1 = new Receivable();
        $instalment1
            ->setAmount($total * 0.15) // 15%
            ->setDueDate(new \DateTime()); // due immediately

        $instalment2 = new Receivable();
        $instalment2
            ->setAmount($total * 0.85) // 85%
            ->setDueDate($courseStartDate->sub(new \DateInterval("P14D"))); // 2 weeks before course starts

        return array(
            $instalment1,
            $instalment2
        );
    }
}
