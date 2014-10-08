<?php
namespace Ice\MercuryClientBundle\Entity;

use Ice\MercuryClientBundle\Util\Lookup;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

class Receivable
{
    /**
     * Constants to be used with setMethod
     */
    const METHOD_RECURRING = 'RECUR';
    const METHOD_ONLINE = 'ONLINE';
    const METHOD_MANUAL = 'MANUAL';
    const METHOD_BACS = 'BACS';
    const METHOD_CHEQUE = 'CHEQUE';
    const METHOD_INVOICE = 'INVOICE';
    const METHOD_PDQ = 'PDQ';
    const METHOD_STUDENT_LOAN = 'STUDENT_LOAN';
    const METHOD_BAD_DEBT = 'BAD_DEBT';

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
     * @var string
     * @JMS\Type("string")
     */
    private $method;

    /**
     * @var TransactionAllocation[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\TransactionAllocation>")
     */
    private $allocations;

    /**
     * @var PaymentGroup
     * @JMS\Type("Ice\MercuryClientBundle\Entity\PaymentGroup")
     */
    private $paymentGroup;

    /**
     * Initialise ArrayCollections
     */
    public function __construct()
    {
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

    /**
     * @param string $method
     * @return Receivable
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getMethodFriendly()
    {
        return Lookup::friendlyPaymentMethodDescription($this->method);
    }

    /**
     * @return int
     */
    public function getAmountAllocated()
    {
        $totalAllocated = 0;
        foreach ($this->getAllocations() as $allocation) {
            $totalAllocated += $allocation->getAmount();
        }
        return $totalAllocated;
    }

    /**
     * @return int
     */
    public function getAmountUnallocated()
    {
        return $this->getAmount() - $this->getAmountAllocated();
    }

    /**
     * True if allocations match amount originally owed
     *
     * @return bool
     */
    public function isBalanced()
    {
        return $this->getAmountAllocated() == $this->getAmount();
    }

    /**
     * @param \Ice\MercuryClientBundle\Entity\PaymentGroup $paymentGroup
     * @return Receivable
     */
    public function setPaymentGroup($paymentGroup)
    {
        $this->paymentGroup = $paymentGroup;
        return $this;
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\PaymentGroup
     */
    public function getPaymentGroup()
    {
        return $this->paymentGroup;
    }
}