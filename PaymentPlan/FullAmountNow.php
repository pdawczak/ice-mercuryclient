<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;

class FullAmountNow implements PaymentPlanInterface
{
    /**
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        $instalment = new Receivable();
        $instalment
            ->setDueDate(new \DateTime())
            ->setAmount($total);

        return array(
            $instalment,
        );
    }
}
