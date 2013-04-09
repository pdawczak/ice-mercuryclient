<?php
namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

class Receivable{
    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var int
     * @JMS\Type("integer")
     */
    private $amount;

    /**
     * @var \DateTime
     * @JMS\Type("DateTime")
     */
    private $dueDate;

    /**
     * @var TransactionAllocation[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\TransactionAllocation>")
     */
    private $allocations;

    /**
     * Initialise ArrayCollections
     */
    public function __construct(){
        $this->allocations = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|TransactionAllocation[]
     */
    public function getAllocations()
    {
        return $this->allocations;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $amount
     *
     * @return Receivable
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param \DateTime $dueDate
     *
     * @return Receivable
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }
}