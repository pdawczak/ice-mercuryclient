<?php

namespace Ice\MercuryClientBundle\Entity;

use Ice\MercuryClientBundle\Entity\Receivable;

interface PaymentPlanInterface {
    /**
     * @param \DateTime $courseStartDate    Start date of course
     * @param int       $total              Total amount owed in pence
     *
     * @return Receivable[]
     */
    public function getReceivables(\DateTime $courseStartDate, $total);

    public function getShortDescription();

    public function getLongDescription();

    /**
     * @param string $method Payment method constant
     *
     * @return PaymentPlanInterface
     */
    public function setPaymentMethod($method);
}