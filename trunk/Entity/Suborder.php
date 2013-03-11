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
}