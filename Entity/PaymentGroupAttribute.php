<?php
namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

class PaymentGroupAttribute
{
    /**
     * @var string
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $serializedValue;

    /**
     * @var \DateTime
     * @JMS\Type("DateTime")
     */
    private $timestamp;

    /**
     * Set default values
     */
    public function __construct(){
        $this->timestamp = new \DateTime();
    }

    /**
     * @param \DateTime $timestamp
     * @return PaymentGroupAttribute
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param string $serializedValue
     * @return PaymentGroupAttribute
     */
    public function setSerializedValue($serializedValue)
    {
        $this->serializedValue = $serializedValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerializedValue()
    {
        return $this->serializedValue;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return unserialize($this->serializedValue);
    }

    /**
     * @param mixed $value
     * @return PaymentGroupAttribute
     */
    public function setValue($value)
    {
        $this->serializedValue = serialize($value);
        return $this;
    }

    /**
     * @param string $name
     * @return PaymentGroupAttribute
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}