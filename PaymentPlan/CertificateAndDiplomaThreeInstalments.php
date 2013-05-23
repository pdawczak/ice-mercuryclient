<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\AbstractPaymentPlan;
use Ice\MercuryClientBundle\Entity\Receivable;
use Ice\MercuryClientBundle\Entity\PaymentPlanInterface;

class CertificateAndDiplomaThreeInstalments extends AbstractPaymentPlan implements PaymentPlanInterface
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
            ->setDueDate(new \DateTime('2013-02-01')); // 1 February 2013

        $instalment3 = new Receivable();
        $instalment3
            ->setAmount($total * 0.33) // 33%
            ->setDueDate(new \DateTime('2013-04-01')); // 1 April 2013

        return array(
            $instalment1,
            $instalment2,
            $instalment3,
        );
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
        return 'Three equal instalments now, in February and in April';
    }
}
