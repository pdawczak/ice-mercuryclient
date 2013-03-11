<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

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
}
