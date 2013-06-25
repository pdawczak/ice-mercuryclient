<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

class TransactionReportLine
{
    /**
     * @var string
     * @JMS\Type("string")
     */
    private $payType;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $cardType;

    /**
     * @var \DateTime
     * @JMS\Type("DateTime")
     */
    private $transactionDate;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $transactionReference;


    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerFullName;


    /**
     * @var string
     * @JMS\Type("string")
     */
    private $bookingReference;

    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $amount;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $financeCode;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $note;

    /**
     * @param int $amount
     * @return TransactionReportLine
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $bookingReference
     * @return TransactionReportLine
     */
    public function setBookingReference($bookingReference)
    {
        $this->bookingReference = $bookingReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getBookingReference()
    {
        return $this->bookingReference;
    }

    /**
     * @param string $cardType
     * @return TransactionReportLine
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @param string $customerFullName
     * @return TransactionReportLine
     */
    public function setCustomerFullName($customerFullName)
    {
        $this->customerFullName = $customerFullName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerFullName()
    {
        return $this->customerFullName;
    }

    /**
     * @param string $financeCode
     * @return TransactionReportLine
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
     * @param string $note
     * @return TransactionReportLine
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $payType
     * @return TransactionReportLine
     */
    public function setPayType($payType)
    {
        $this->payType = $payType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayType()
    {
        return $this->payType;
    }

    /**
     * @param \DateTime $transactionDate
     * @return TransactionReportLine
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param string $transactionReference
     * @return TransactionReportLine
     */
    public function setTransactionReference($transactionReference)
    {
        $this->transactionReference = $transactionReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->transactionReference;
    }
}