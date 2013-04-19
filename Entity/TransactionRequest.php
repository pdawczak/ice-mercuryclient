<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * Ice\MercuryClientBundle\Entity\TransactionRequest
 */
class TransactionRequest{
    /**
     * @var integer $id
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string $reference
     * @JMS\Type("string")
     */
    private $reference;

    /**
     * @var TransactionRequestComponent[] $components
     * @JMS\Type("array<Ice\MercuryClientBundle\Entity\TransactionRequestComponent>")
     */
    private $components = array();

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $iceId;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $requestAccountTypeDescription = 'ECOM';

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $requestCurrency = 'GBP';

    /**
     * @var \DateTime $created
     * @JMS\Type("DateTime")
     */
    private $created;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $reference
     * @return TransactionRequest
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param TransactionRequestComponent[] $components
     * @return TransactionRequest
     */
    public function setComponents($components)
    {
        $this->components = array();
        foreach($components as $component){
            $component->setRequest($this);
            $this->components[] = $component;
        }
        return $this;
    }

    /**
     * @return TransactionRequestComponent[]
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @param string $iceId
     * @return TransactionRequest
     */
    public function setIceId($iceId)
    {
        $this->iceId = $iceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getIceId()
    {
        return $this->iceId;
    }

    /**
     * @param \DateTime $created
     * @return TransactionRequest
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $requestAccountTypeDescription
     * @return TransactionRequest
     */
    public function setRequestAccountTypeDescription($requestAccountTypeDescription)
    {
        $this->requestAccountTypeDescription = $requestAccountTypeDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestAccountTypeDescription()
    {
        return $this->requestAccountTypeDescription;
    }

    /**
     * @param string $requestCurrency
     * @return TransactionRequest
     */
    public function setRequestCurrency($requestCurrency)
    {
        $this->requestCurrency = $requestCurrency;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestCurrency()
    {
        return $this->requestCurrency;
    }

    /**
     * Get the total amount (to be) requested, in pence.
     *
     * @return int
     */
    public function getTotalRequestAmount(){
        $total = 0;
        foreach($this->getComponents() as $component){
            $total += $component->getRequestAmount();
        }
        return $total;
    }

    /**
     * @return string
     */
    public function getIframeUrl(array $extraParams = array()){
        $root = "https://payments.securetrading.net/process/payments/choice";
        $params = array(
            'childcss'=>'stpp-public',
            'childjs'=>'stpp-resize',
            'sitereference'=>'test_uniofcam45561',
            'mainamount'=>$this->getTotalRequestAmount() / 100,
            'currencyiso3a'=>'GBP',
            'version'=>1,
            'accounttypedescription'=>'MOTO',
            'orderreference'=>$this->getReference()
        );
        $queryString = http_build_query(array_merge($extraParams, $params));
        return $root.'?'.$queryString;
    }
}