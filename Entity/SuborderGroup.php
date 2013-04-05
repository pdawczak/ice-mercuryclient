<?php
namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

class SuborderGroup{
    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var Receivable[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\Receivable>")
     */
    private $receivables;

    /**
     * @var Suborder[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\Suborder>")
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
     * @return SuborderGroup
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $receivables
     * @return SuborderGroup
     */
    public function setReceivables($receivables)
    {
        $this->receivables = $receivables;
        return $this;
    }

    /**
     * @param ArrayCollection|Suborder[] $suborders
     * @return SuborderGroup
     */
    public function setSuborders($suborders)
    {
        foreach($suborders as $suborder){
            $suborder->setGroup($this);
        }
        $this->suborders = $suborders;
        return $this;
    }
}