<?php
namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * Allocates an amount of a transaction to a receivable
 */
class TransactionAllocation{
    /**
     * @var integer $id
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $amount;

    /**
     * @var Transaction
     * @JMS\Type("Ice\MercuryClientBundle\Entity\Transaction")
     */
    private $transaction;

    /**
     * @var Receivable
     * @JMS\Type("Ice\MercuryClientBundle\Entity\Receivable")
     */
    private $receivable;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param \Ice\MercuryClientBundle\Entity\Receivable $receivable
     * @return TransactionAllocation
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
}