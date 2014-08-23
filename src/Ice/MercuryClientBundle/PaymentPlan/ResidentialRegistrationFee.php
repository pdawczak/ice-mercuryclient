<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\AbstractPaymentPlan;
use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;

class ResidentialRegistrationFee extends AbstractPaymentPlan implements PaymentPlanInterface
{
    /**
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        $instalment1 = new Receivable();
        $instalment1
            ->setAmount($total * 0.15) // 15%
            ->setDueDate(null) // due immediately
        ;

        $instalment2 = new Receivable();
        $instalment2
            ->setAmount($total * 0.85) // 85%
            ->setDueDate($courseStartDate->sub(new \DateInterval("P14D"))) // 2 weeks before course starts
        ;

        /** @var Receivable[] $receivables */
        $receivables =  array(
            $instalment1,
            $instalment2
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
    public function getShortDescription()
    {
        return '15% now, remainder later';
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return '15% now, remainder later';
    }
}
