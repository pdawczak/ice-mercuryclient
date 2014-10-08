<?php
namespace Ice\MercuryClientBundle\Entity;

use Ice\MercuryClientBundle\Exception\AttributeNotFoundException;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

class PaymentGroup
{
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
     * @var PaymentGroupAttribute[]|ArrayCollection
     * @JMS\Type("ArrayCollection<Ice\MercuryClientBundle\Entity\PaymentGroupAttribute>")
     */
    private $attributes;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $externalId;

    /**
     * @var Authorisation
     * @JMS\Type("Ice\MercuryClientBundle\Entity\Authorisation")
     */
    private $preferredAuthorisation;

    /**
     * Initialise ArrayCollections
     */
    public function __construct()
    {
        $this->receivables = new ArrayCollection();
        $this->suborders = new ArrayCollection();
        $this->attributes = new ArrayCollection();
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
        foreach ($suborders as $suborder) {
            $suborder->setPaymentGroup($this);
        }
        $this->suborders = $suborders;
        return $this;
    }

    /**
     * @param PaymentGroupAttribute[]|ArrayCollection $attributes
     * @return PaymentGroup
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return PaymentGroup
     */
    public function setAttributeByNameAndValue($name, $value)
    {
        try {
            $this->getAttributeByName($name)->setValue($value);
        } catch (AttributeNotFoundException $e) {
            $newAttribute = new PaymentGroupAttribute();
            $newAttribute->setName($name)->setValue($value);
            $this->attributes->add($newAttribute);
        }
        return $this;
    }

    /**
     * @param $name
     * @return PaymentGroupAttribute
     * @throws \Ice\MercuryClientBundle\Exception\AttributeNotFoundException
     */
    public function getAttributeByName($name)
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getName() === $name) {
                return $attribute;
            }
        }
        throw new AttributeNotFoundException("Attribute '$name' does not exist on payment group " . $this->getId());
    }

    /**
     * @return ArrayCollection|PaymentGroupAttribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $externalId
     * @return PaymentGroup
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * Get the amount due to pay online
     *
     * @return int
     */
    public function getOutstandingOnlineFirstPaymentAmount()
    {
        $amount = 0;
        foreach($this->receivables as $receivable) {
            if (
                Receivable::METHOD_ONLINE === $receivable->getMethod() &&
                $receivable->getDueDate() === null
            ) {
                $amount += $receivable->getAmountUnallocated();
            }
        }
        return $amount;
    }

    /**
     * @param \Ice\MercuryClientBundle\Entity\Authorisation $preferredAuthorisation
     * @return PaymentGroup
     */
    public function setPreferredAuthorisation($preferredAuthorisation)
    {
        $this->preferredAuthorisation = $preferredAuthorisation;
        return $this;
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\Authorisation
     */
    public function getPreferredAuthorisation()
    {
        return $this->preferredAuthorisation;
    }
}