<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\AbstractPaymentPlan;
use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;

class TwoYearSixInstalments1416February extends AbstractPaymentPlan implements PaymentPlanInterface
{
    /**
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        $instalment1 = new Receivable();
        $instalment1
            ->setAmount($total * 0.20) // 20%
            ->setDueDate(null); // due immediately

        $instalment2 = new Receivable();
        $instalment2
            ->setAmount($total * 0.15) // 15%
            ->setDueDate(new \DateTime('2015-02-01')); // 1 February 2015

        $instalment3 = new Receivable();
        $instalment3
            ->setAmount($total * 0.15) // 15%
            ->setDueDate(new \DateTime('2015-05-01')); // 1 May 2015

        $instalment4 = new Receivable();
        $instalment4
            ->setAmount($total * 0.20) // 20%
            ->setDueDate(new \DateTime('2015-11-01')); // 1 November 2015

        $instalment5 = new Receivable();
        $instalment5
            ->setAmount($total * 0.15) // 15%
            ->setDueDate(new \DateTime('2016-02-01')); // 1 February 2016

        $instalment6 = new Receivable();
        $instalment6
            ->setAmount($total * 0.15) // 15%
            ->setDueDate(new \DateTime('2016-05-01')); // 1 May 2016

        /** @var Receivable[] $receivables */
        $receivables =  array(
            $instalment1,
            $instalment2,
            $instalment3,
            $instalment4,
            $instalment5,
            $instalment6,
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
        return 'Six instalments over two years';
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return 'Six instalments over two years';
    }
}
