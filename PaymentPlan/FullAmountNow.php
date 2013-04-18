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
            ->setDueDate(null)
            ->setAmount($total)
            ->setMethod(Receivable::METHOD_ONLINE);

        return array(
            $instalment,
        );
    }

    /**
     * @return string
     */
    public function getShortDescription(){
        return 'Pay the full amount now';
    }

    /**
     * @return string
     */
    public function getLongDescription(){
        return 'Pay the full amount now';
    }
}
