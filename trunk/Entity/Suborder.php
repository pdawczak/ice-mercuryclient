<?php
namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

class Suborder{
    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $paymentPlanDescription;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @var LineItem[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\LineItem>")
     */
    private $lineItems;

    /**
     * @var SuborderGroup
     * @JMS\Type("Ice\MercuryClientBundle\Entity\SuborderGroup")
     */
    private $group;

    /**
     * @var Order
     * @JMS\Type("Ice\MercuryClientBundle\Entity\Order")
     */
    private $order;

    /**
     * Initialise ArrayCollections
     */
    public function __construct(){
        $this->lineItems = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|SuborderGroup[]
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|LineItem[]
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * @return string
     */
    public function getPaymentPlanDescription()
    {
        return $this->paymentPlanDescription;
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $description
     * @return Suborder
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param \Ice\MercuryClientBundle\Entity\SuborderGroup $group
     * @return Suborder
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @param int $id
     * @return Suborder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection|LineItem[] $lineItems
     * @return Suborder
     */
    public function setLineItems($lineItems)
    {
        $this->lineItems = $lineItems;
        return $this;
    }

    /**
     * @param \Ice\MercuryClientBundle\Entity\Order $order
     * @return Suborder
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param string $paymentPlanDescription
     * @return Suborder
     */
    public function setPaymentPlanDescription($paymentPlanDescription)
    {
        $this->paymentPlanDescription = $paymentPlanDescription;
        return $this;
    }
}