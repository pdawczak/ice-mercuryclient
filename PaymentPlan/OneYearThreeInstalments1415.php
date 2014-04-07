<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\AbstractPaymentPlan;
use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;

class OneYearThreeInstalments1415 extends AbstractPaymentPlan implements PaymentPlanInterface
{
    /**
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        $instalment1 = new Receivable();
        $instalment1
            ->setAmount($total * 0.34) // 34%
            ->setDueDate(null); // due immediately

        $instalment2 = new Receivable();
        $instalment2
            ->setAmount($total * 0.33) // 33%
            ->setDueDate(new \DateTime('2014-11-01')); // 1 Nov 2014

        $instalment3 = new Receivable();
        $instalment3
            ->setAmount($total * 0.33) // 33%
            ->setDueDate(new \DateTime('2015-02-01')); // 1 Feb 2015

        /** @var Receivable[] $receivables */
        $receivables =  array(
            $instalment1,
            $instalment2,
            $instalment3,
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
        return 'Three instalments';
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return 'Three equal instalments now, in November and in February';
    }
}
