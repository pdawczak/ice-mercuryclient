<?php
namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

class PaymentGroup{
    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var Receivable[]|ArrayCollection
     * @JMS\Type("array<Ice\MercuryClientBundle\Entity\Receivable>")
     */
    private $receivables;

    /**
     * @var Suborder[]|ArrayCollection
     * @JMS\Type("array<Ice\MercuryClientBundle\Entity\Suborder>")
     */
    private $suborders;

    /**
     * Initialise ArrayCollections
     */
    public function __construct(){
        $this->receivables = new ArrayCollection();
        $this->suborders = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|Receivable[]
     */
    public function getReceivables()
    {
        return $this->receivables;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|Suborder[]
     */
    public function getSuborders()
    {
        return $this->suborders;
    }

    /**
     * @param int $id
     * @return PaymentGroup
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $receivables
     * @return PaymentGroup
     */
    public function setReceivables($receivables)
    {
        $this->receivables = $receivables;
        return $this;
    }

    /**
     * @param ArrayCollection|Suborder[] $suborders
     * @return PaymentGroup
     */
    public function setSuborders($suborders)
    {
        foreach($suborders as $suborder){
            $suborder->setPaymentGroup($this);
        }
        $this->suborders = $suborders;
        return $this;
    }
}