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
     * @var string
     * @JMS\Type("string")
     */
    private $customerTitle;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerFirstNames;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerMiddleNames;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerLastNames;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerAddress1;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerAddress2;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerAddress3;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerAddress4;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerTown;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerCounty;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerPostcode;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerCountry;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerTelephone;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerMobile;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $customerEmail;

    /**
     * @var Suborder[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\Suborder>")
     */
    private $suborders;

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
     * @param Suborder $suborder
     * @return $this
     */
    public function addSuborder(Suborder $suborder){
        $suborder->setOrder($this);
        $this->suborders->add($suborder);
        return $this;
    }

    /**
     * @param string $customerAddress1
     * @return Order
     */
    public function setCustomerAddress1($customerAddress1)
    {
        $this->customerAddress1 = $customerAddress1;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerAddress1()
    {
        return $this->customerAddress1;
    }

    /**
     * @param string $customerAddress2
     * @return Order
     */
    public function setCustomerAddress2($customerAddress2)
    {
        $this->customerAddress2 = $customerAddress2;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerAddress2()
    {
        return $this->customerAddress2;
    }

    /**
     * @param string $customerAddress3
     * @return Order
     */
    public function setCustomerAddress3($customerAddress3)
    {
        $this->customerAddress3 = $customerAddress3;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerAddress3()
    {
        return $this->customerAddress3;
    }

    /**
     * @param string $customerAddress4
     * @return Order
     */
    public function setCustomerAddress4($customerAddress4)
    {
        $this->customerAddress4 = $customerAddress4;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerAddress4()
    {
        return $this->customerAddress4;
    }

    /**
     * @param string $customerCountry
     * @return Order
     */
    public function setCustomerCountry($customerCountry)
    {
        $this->customerCountry = $customerCountry;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerCountry()
    {
        return $this->customerCountry;
    }

    /**
     * @param string $customerEmail
     * @return Order
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerFirstNames
     * @return Order
     */
    public function setCustomerFirstNames($customerFirstNames)
    {
        $this->customerFirstNames = $customerFirstNames;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerFirstNames()
    {
        return $this->customerFirstNames;
    }

    /**
     * @param string $customerLastNames
     * @return Order
     */
    public function setCustomerLastNames($customerLastNames)
    {
        $this->customerLastNames = $customerLastNames;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerLastNames()
    {
        return $this->customerLastNames;
    }

    /**
     * @param string $customerMiddleNames
     * @return Order
     */
    public function setCustomerMiddleNames($customerMiddleNames)
    {
        $this->customerMiddleNames = $customerMiddleNames;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerMiddleNames()
    {
        return $this->customerMiddleNames;
    }

    /**
     * @param string $customerMobile
     * @return Order
     */
    public function setCustomerMobile($customerMobile)
    {
        $this->customerMobile = $customerMobile;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerMobile()
    {
        return $this->customerMobile;
    }

    /**
     * @param string $customerPostcode
     * @return Order
     */
    public function setCustomerPostcode($customerPostcode)
    {
        $this->customerPostcode = $customerPostcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerPostcode()
    {
        return $this->customerPostcode;
    }

    /**
     * @param string $customerTelephone
     * @return Order
     */
    public function setCustomerTelephone($customerTelephone)
    {
        $this->customerTelephone = $customerTelephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerTelephone()
    {
        return $this->customerTelephone;
    }

    /**
     * @param string $customerTitle
     * @return Order
     */
    public function setCustomerTitle($customerTitle)
    {
        $this->customerTitle = $customerTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerTitle()
    {
        return $this->customerTitle;
    }

    /**
     * @return int
     */
    public function getTotalAmount()
    {
        $total = 0;
        foreach($this->getSuborders() as $suborder) {
            $total += $suborder->getTotalAmount();
        }
        return $total;
    }

    /**
     * Get the full name in the format Title First Middle Last
     *
     * @return string
     */
    public function getCustomerFullName()
    {
        $names = array(
            $this->getCustomerTitle(),
            $this->getCustomerFirstNames(),
            $this->getCustomerMiddleNames(),
            $this->getCustomerLastNames(),
        );

        $names = array_filter($names);

        return implode(" ", $names);
    }

    /**
     * @param string $customerCounty
     * @return Order
     */
    public function setCustomerCounty($customerCounty)
    {
        $this->customerCounty = $customerCounty;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerCounty()
    {
        return $this->customerCounty;
    }

    /**
     * @param string $customerTown
     * @return Order
     */
    public function setCustomerTown($customerTown)
    {
        $this->customerTown = $customerTown;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerTown()
    {
        return $this->customerTown;
    }
}
