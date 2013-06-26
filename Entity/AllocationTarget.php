<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * AllocationTarget
 */
class AllocationTarget
{
    const STRATEGY_NEXT_PAYMENT = 'NEXT_PAYMENT';

    /**
     * @var integer
     *
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $financeCode;

    /**
     * @var float
     *
     * @JMS\Type("double")
     */
    private $weight;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $strategy;

    /**
     * @param int $id
     * @return AllocationTarget
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $financeCode
     * @return AllocationTarget
     */
    public function setFinanceCode($financeCode)
    {
        $this->financeCode = $financeCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getFinanceCode()
    {
        return $this->financeCode;
    }

    /**
     * @param string $strategy
     * @return AllocationTarget
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
        return $this;
    }

    /**
     * @return string
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @param float $weight
     * @return AllocationTarget
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }
}