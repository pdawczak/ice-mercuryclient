<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @JMS\AccessType("public_method")
 */
class Order{
    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $iceId;

    /**
     * @var \DateTime
     * @JMS\Type("DateTime")
     */
    private $created;

    /**
     * @var Suborder[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\Suborder>")
     */
    private $suborders;

    /**
     * @var \Ice\JanusClientBundle\Response\User
     * @JMS\Exclude
     */
    private $customer;

    /**
     * Initialise ArrayCollections
     */
    public function __construct(){
        $this->suborders = new ArrayCollection();
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getIceId()
    {
        return $this->iceId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|Suborder[]
     */
    public function getSuborders()
    {
        return $this->suborders;
    }

    /**
     * @param \DateTime $created
     * @return Order
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @param string $iceId
     * @return Order
     */
    public function setIceId($iceId)
    {
        $this->iceId = $iceId;
        return $this;
    }

    /**
     * @param int $id
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param ArrayCollection|Suborder[] $suborders
     * @return Order
     */
    public function setSuborders($suborders)
    {
        foreach($suborders as $suborder){
            $suborder->setOrder($this);
        }
        $this->suborders = $suborders;
        return $this;
    }

    /**
     * @param \Ice\JanusClientBundle\Response\User $customer
     * @return Order
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return \Ice\JanusClientBundle\Response\User
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
