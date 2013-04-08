<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;

class AbstractPaymentPlan implements PaymentPlanInterface
{
    /**
     * @var \DateTime
     */
    protected $courseStartDate;

    /**
     * @var int
     */
    protected $total;

    /**
     *
     * {@inheritDoc}
     */
    public function getReceivables(\DateTime $courseStartDate, $total)
    {
        throw new \RuntimeException('getReceivables must be implemented.');
    }
}
