<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\AbstractPaymentPlan;
use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;

class FullAmountNow extends AbstractPaymentPlan implements PaymentPlanInterface
{
    /**
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        $instalment = new Receivable();
        $instalment
            ->setDueDate(null)
            ->setAmount($total);

        $receivables = array(
            $instalment,
        );

        if ($this->paymentMethod) {
            foreach ($receivables as $receivable) {
                $receivable->setMethod($this->paymentMethod);
            }
        }

        return $receivables;
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
