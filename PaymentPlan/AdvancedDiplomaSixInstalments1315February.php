<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;

class AdvancedDiplomaSixInstalments1315February extends AbstractPaymentPlan
{
    /**
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        $instalment1 = new Receivable();
        $instalment1
            ->setAmount($total * 0.17) // 17%
            ->setDueDate(new \DateTime()); // due immediately

        $instalment2 = new Receivable();
        $instalment2
            ->setAmount($total * 0.16) // 16%
            ->setDueDate(new \DateTime('2014-02-01')); // 1 February 2014

        $instalment3 = new Receivable();
        $instalment3
            ->setAmount($total * 0.16) // 16%
            ->setDueDate(new \DateTime('2014-05-01')); // 1 May 2014

        $instalment4 = new Receivable();
        $instalment4
            ->setAmount($total * 0.16) // 16%
            ->setDueDate(new \DateTime('2014-11-01')); // 1 November 2014

        $instalment5 = new Receivable();
        $instalment5
            ->setAmount($total * 0.16) // 16%
            ->setDueDate(new \DateTime('2015-02-01')); // 1 February 2015

        $instalment6 = new Receivable();
        $instalment6
            ->setAmount($total * 0.16) // 16%
            ->setDueDate(new \DateTime('2015-05-01')); // 1 May 2015

        return array(
            $instalment1,
            $instalment2,
            $instalment3,
            $instalment4,
            $instalment5,
            $instalment6,
        );
    }
}
