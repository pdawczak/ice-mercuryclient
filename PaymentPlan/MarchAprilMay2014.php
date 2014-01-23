<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\AbstractPaymentPlan;
use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;

class MarchAprilMay2014 extends AbstractPaymentPlan implements PaymentPlanInterface
{
    /**
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        $instalment1 = new Receivable();
        $instalment1
            ->setAmount($total * 0.25)
            ->setDueDate(null); // due immediately

        $instalment2 = new Receivable();
        $instalment2
            ->setAmount($total * 0.25)
            ->setDueDate(new \DateTime('2013-03-01'));

        $instalment3 = new Receivable();
        $instalment3
            ->setAmount($total * 0.25)
            ->setDueDate(new \DateTime('2014-04-01'));

        $instalment4 = new Receivable();
        $instalment4
            ->setAmount($total * 0.25)
            ->setDueDate(new \DateTime('2014-05-01'));

        /** @var Receivable[] $receivables */
        $receivables =  array(
            $instalment1,
            $instalment2,
            $instalment3,
            $instalment4,
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
        return 'Four monthly instalments';
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return 'Four equal instalments now, in March, April and May';
    }
}
