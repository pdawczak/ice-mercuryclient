<?php

namespace Ice\MercuryClientBundle\Entity;

use JMS\Serializer\Annotation as JMS;

class TransactionRequestComponent
{
    /**
     * @var integer $id
     *
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var TransactionRequest
     *
     * @ORM\ManyToOne(targetEntity="TransactionRequest", inversedBy="components",cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $request;

    /**
     * @var PaymentGroup
     *
     * @ORM\ManyToOne(targetEntity="PaymentGroup")
     **/
    private $paymentGroup;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $requestAmount;

    /**
     * Initialise properties
     */
    public function __construct(){
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Ice\MercuryBundle\Entity\PaymentGroup $request
     * @return TransactionRequestComponent
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return \Ice\MercuryBundle\Entity\TransactionRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param $group
     * @return TransactionRequestComponent
     */
    public function setPaymentGroup($group)
    {
        $this->paymentGroup = $group;
        return $this;
    }

    /**
     * @return PaymentGroup
     */
    public function getPaymentGroup()
    {
        return $this->paymentGroup;
    }

    /**
     * @param int $requestAmount
     * @return TransactionRequestComponent
     */
    public function setRequestAmount($requestAmount)
    {
        $this->requestAmount = $requestAmount;
        return $this;
    }

    /**
     * @return int
     */
    public function getRequestAmount()
    {
        return $this->requestAmount;
    }

    /**
     * Return true if this is a refund (ie, amount < 0)
     *
     * @return bool
     */
    public function isRefund(){
        return $this->getRequestAmount() < 0;
    }
}