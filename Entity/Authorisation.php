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
}