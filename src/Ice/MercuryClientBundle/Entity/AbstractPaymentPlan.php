<?php

namespace Ice\MercuryClientBundle\Entity;

class AbstractPaymentPlan
{
    protected $paymentMethod;

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Updates the payment method
     *
     * @param Receivable[] $receivables
     */
    protected function updatePaymentMethodForReceivables(array $receivables)
    {

    }
}
