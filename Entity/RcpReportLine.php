<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

class RcpReportLine
{
    /**
     * @var Receivable
     * @JMS\Type("Ice\MercuryClientBundle\Entity\Receivable")
     */
    private $receivable;

    /**
     * @param \Ice\MercuryClientBundle\Entity\Receivable $receivable
     * @return RcpReportLine
     */
    public function setReceivable($receivable)
    {
        $this->receivable = $receivable;
        return $this;
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\Receivable
     */
    public function getReceivable()
    {
        return $this->receivable;
    }

    /**
     * Return an array of unique booking references.
     *
     * @return array
     */
    public function getBookingReferences()
    {
        $references = [];
        foreach ($this->receivable->getPaymentGroup()->getSuborders() as $suborder) {
            if (!in_array($suborder->getExternalId(), $references)) {
                $references[] = $suborder->getExternalId();
            }
        }
        return $references;
    }
}