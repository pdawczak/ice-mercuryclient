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
     * @JMS\Type("Ice\MercuryClientBundle\Entity\TransactionRequest")
     */
    private $request;

    /**
     * @var PaymentGroup
     *
     * @JMS\Type("Ice\MercuryClientBundle\Entity\PaymentGroup")
     **/
    private $paymentGroup;

    /**
     * @var string
     */
    private $paymentGroupExternalId;

    /**
     * @var int
     *
     * @JMS\Type("integer")
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
     * @param \Ice\MercuryClientBundle\Entity\TransactionRequest $request
     * @return TransactionRequestComponent
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return \Ice\MercuryClientBundle\Entity\TransactionRequest $request
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

    /**
     * @param string $paymentGroupExternalId
     * @return TransactionRequestComponent
     */
    public function setPaymentGroupExternalId($paymentGroupExternalId)
    {
        $this->paymentGroupExternalId = $paymentGroupExternalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentGroupExternalId()
    {
        return $this->paymentGroupExternalId;
    }
}