<?php

namespace Ice\MercuryClientBundle\PaymentPlan;

use Ice\MercuryClientBundle\Entity\Receivable;

interface PaymentPlanInterface {
    /**
     * @param \DateTime $courseStartDate    Start date of course
     * @param int       $total              Total amount owed in pence
     *
     * @return Receivable[]
     */
    public function getReceivables(\DateTime $courseStartDate, $total);
}