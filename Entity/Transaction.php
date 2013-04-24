<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * Ice\MercuryClientBundle\Entity\Transaction
 */
class Transaction
{
    /**
     * @var integer $id
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var int $amountReceived
     * @JMS\Type("string")
     */
    private $amountReceived;

    /**
     * @param int $amountReceived
     * @return TransactionRequest
     */
    public function setAmountReceived($amountReceived)
    {
        $this->amountReceived = $amountReceived;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmountReceived()
    {
        return $this->amountReceived;
    }

    /**
     * @param int $id
     * @return TransactionRequest
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
}