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
     * Initialise ArrayCollections
     */
    public function __construct(){
        $this->receivables = new ArrayCollection();
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
}