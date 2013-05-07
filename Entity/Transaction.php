<?php

namespace Ice\MercuryClientBundle\Entity;

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
     * @var TransactionRequest
     * @JMS\Type("Ice\MercuryClientBundle\Entity\TransactionRequest")
     */
    private $transactionRequest;

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
}