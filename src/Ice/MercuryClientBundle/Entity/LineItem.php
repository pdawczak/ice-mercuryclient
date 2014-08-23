<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

class LineItem{
    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $costCentre;

    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $amount;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $externalId;

    /**
     * @var AllocationTarget[]
     * @JMS\Type("array<Ice\MercuryClientBundle\Entity\AllocationTarget>")
     */
    private $allocationTargets = [];

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCostCentre()
    {
        return $this->costCentre;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $amount
     * @return LineItem
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string $costCentre
     * @return LineItem
     */
    public function setCostCentre($costCentre)
    {
        $this->costCentre = $costCentre;
        return $this;
    }

    /**
     * @param string $description
     * @return LineItem
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param int $id
     * @return LineItem
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $externalId
     * @return LineItem
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param AllocationTarget $allocationTarget
     * @return LineItem
     */
    public function addAllocationTarget(AllocationTarget $allocationTarget)
    {
        $this->allocationTargets[] = $allocationTarget;
        return $this;
    }

    /**
     * @param AllocationTarget[] $allocationTargets
     * @return LineItem
     */
    public function setAllocationTargets($allocationTargets)
    {
        $this->allocationTargets = $allocationTargets;
        return $this;
    }

    /**
     * @return string
     */
    public function getAllocationTargets()
    {
        return $this->allocationTargets;
    }
}