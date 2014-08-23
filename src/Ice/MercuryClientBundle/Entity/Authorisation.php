<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * Authorisation
 */
class Authorisation
{
    /**
     * @var integer
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string $iceId
     * @JMS\Type("string")
     */
    private $iceId;

    /**
     * @var string $transactionReference
     * @JMS\Type("string")
     */
    private $transactionReference;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $maskedPan;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $cardholderFullName;

    /**
     * @var \DateTime
     * @JMS\Type("DateTime")
     */
    private $expiryDate;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $paymentType;

    /**
     * @param string $iceId
     * @return Authorisation
     */
    public function setIceId($iceId)
    {
        $this->iceId = $iceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getIceId()
    {
        return $this->iceId;
    }

    /**
     * @param int $id
     * @return Authorisation
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
     * @param string $transactionReference
     * @return Authorisation
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

    /**
     * @param string $cardholderFullName
     * @return Authorisation
     */
    public function setCardholderFullName($cardholderFullName)
    {
        $this->cardholderFullName = $cardholderFullName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardholderFullName()
    {
        return $this->cardholderFullName;
    }

    /**
     * @param \DateTime $expiryDate
     * @return Authorisation
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @param string $maskedPan
     * @return Authorisation
     */
    public function setMaskedPan($maskedPan)
    {
        $this->maskedPan = $maskedPan;
        return $this;
    }

    /**
     * @return string
     */
    public function getMaskedPan()
    {
        return $this->maskedPan;
    }

    /**
     * @param string $paymentType
     * @return Authorisation
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }
}
