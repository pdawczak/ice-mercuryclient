<?php

namespace Ice\MercuryClientBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Ice\MercuryClientBundle\Entity\Transaction
 */
class Transaction
{
    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $amountReceived;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $currency;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $method;

    /**
     * @var \DateTime $created
     * @JMS\Type("DateTime")
     */
    private $created;

    /**
     * @var TransactionRequest
     * @JMS\Type("Ice\MercuryClientBundle\Entity\TransactionRequest")
     */
    private $transactionRequest;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $reference;

    /**
     * @var TransactionAllocation[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\TransactionAllocation>")
     */
    private $allocations;

    /**
     * Initialise ArrayCollections
     */
    public function __construct()
    {
        $this->allocations = new ArrayCollection();
    }

    /**
     * @param int $amountReceived
     * @return Transaction
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
     * @return Transaction
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
     * @param string $currency
     * @return Transaction
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $method
     * @return Transaction
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param \Ice\MercuryClientBundle\Entity\TransactionRequest $transactionRequest
     * @return Transaction
     */
    public function setTransactionRequest($transactionRequest)
    {
        $this->transactionRequest = $transactionRequest;
        return $this;
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\TransactionRequest
     */
    public function getTransactionRequest()
    {
        return $this->transactionRequest;
    }

    /**
     * @param \DateTime $created
     * @return Transaction
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $reference
     * @return Transaction
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection|\Ice\MercuryClientBundle\Entity\TransactionAllocation[] $allocations
     * @return Transaction
     */
    public function setAllocations($allocations)
    {
        $this->allocations = $allocations;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Ice\MercuryClientBundle\Entity\TransactionAllocation[]
     */
    public function getAllocations()
    {
        return $this->allocations;
    }
}